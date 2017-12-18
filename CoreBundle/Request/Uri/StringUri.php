<?php
declare(strict_types=1);
/**
 * This file is part of beotie/core_bundle
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.1
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Request\Uri;

use Psr\Http\Message\UriInterface;
use Beotie\CoreBundle\Request\Uri\StringUriElement\AuthorityElementTrait;
use Beotie\CoreBundle\Request\Uri\StringUriElement\SchemeElementTrait;
use Beotie\CoreBundle\Request\Uri\StringUriElement\PathElementTrait;
use Beotie\CoreBundle\Request\Uri\StringUriElement\QueryElementTrait;
use Beotie\CoreBundle\Request\Uri\StringUriElement\FragmentElementTrait;

/**
 * String uri
 *
 * This class is used as UriInterface implemantation, based on a string url.
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class StringUri implements UriInterface, PortMappingInterface
{
    use AuthorityElementTrait,
        SchemeElementTrait,
        PathElementTrait,
        QueryElementTrait,
        FragmentElementTrait;

    /**
     * Host
     *
     * This property store the host part of the url
     *
     * @var string
     */
    protected $host = '';

    /**
     * Port
     *
     * This property store the port part of the url
     *
     * @var integer|null
     */
    protected $port = null;

    /**
     * User
     *
     * This property store the user part of the url
     *
     * @var string
     */
    protected $user = '';

    /**
     * Password
     *
     * This property store the password part of the url
     *
     * @var string
     */
    protected $pass = '';

    /**
     * Construct
     *
     * The default StringUri constructor
     *
     * @param string $uri The string representation of the URI
     *
     * @return void
     */
    public function __construct(string $uri)
    {
        $components = parse_url($uri);

        $componentKeys = [
            'scheme',
            'path',
            'query',
            'fragment',
            'host',
            'port',
            'user',
            'pass'
        ];

        foreach ($componentKeys as $component) {
            if (!empty($components[$component])) {
                $this->{$component} = $components[$component];
            }
        }
    }

    /**
     * Return an instance with the specified host.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified host.
     *
     * An empty host value is equivalent to removing the host.
     *
     * @param string $host The hostname to use with the new instance.
     *
     * @return static A new instance with the specified host.
     * @throws \InvalidArgumentException for invalid hostnames.
     */
    public function withHost($host)
    {
        return $this->duplicateWith('host', $host);
    }

    /**
     * Return an instance with the specified port.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified port.
     *
     * Implementations MUST raise an exception for ports outside the
     * established TCP and UDP port ranges.
     *
     * A null value provided for the port is equivalent to removing the port
     * information.
     *
     * @param null|int $port The port to use with the new instance; a null value
     *                       removes the port information.
     *
     * @return static A new instance with the specified port.
     * @throws \InvalidArgumentException for invalid ports.
     */
    public function withPort($port)
    {
        if ($port > 65535 || $port < 0 || !is_int($port)) {
            throw new \RuntimeException('Out of TCP/UDP allowed range');
        }

        return $this->duplicateWith('port', $port);
    }

    /**
     * Return the string representation as a URI reference.
     *
     * Depending on which components of the URI are present, the resulting
     * string is either a full URI or relative reference according to RFC 3986,
     * Section 4.1. The method concatenates the various components of the URI,
     * using the appropriate delimiters:
     *
     * - If a scheme is present, it MUST be suffixed by ":".
     * - If an authority is present, it MUST be prefixed by "//".
     * - The path can be concatenated without delimiters. But there are two
     *   cases where the path has to be adjusted to make the URI reference
     *   valid as PHP does not allow to throw an exception in __toString():
     *     - If the path is rootless and an authority is present, the path MUST
     *       be prefixed by "/".
     *     - If the path is starting with more than one "/" and no authority is
     *       present, the starting slashes MUST be reduced to one.
     * - If a query is present, it MUST be prefixed by "?".
     * - If a fragment is present, it MUST be prefixed by "#".
     *
     * @see    http://tools.ietf.org/html/rfc3986#section-4.1
     * @return string
     */
    public function __toString()
    {
        $query = $this->getQuery();
        if ($query) {
            $query = sprintf('?%s', $query);
        }

        $fragment = $this->getFragment();
        if ($fragment) {
            $fragment = sprintf('#%s', $fragment);
        }

        $base = sprintf('%s%s%s', $this->getSchemeElement(), $this->getAuthorityPart(), $this->getPath());
        $complement = sprintf('%s%s', $query, $fragment);

        return sprintf('%s%s', $base, $complement);
    }

    /**
     * Retrieve the port component of the URI.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard port
     * used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme, but SHOULD return null.
     *
     * @return null|int The URI port.
     */
    public function getPort()
    {
        if ($this->port !== $this->getStandardSchemePort($this->scheme)) {
            return intval($this->port);
        }

        return null;
    }

    /**
     * Return an instance with the specified user information.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified user information.
     *
     * Password is optional, but the user information MUST include the
     * user; an empty string for the user is equivalent to removing user
     * information.
     *
     * @param string      $user     The user name to use for authority.
     * @param null|string $password The password associated with $user.
     *
     * @return static A new instance with the specified user information.
     */
    public function withUserInfo($user, $password = null)
    {
        $instance = $this->duplicateWith('user', $user);
        if (empty($user)) {
            $instance->pass = '';
        }

        if (!empty($password) && !empty($user)) {
            $instance->pass = $password;
        }

        return $instance;
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * If no user information is present, this method MUST return an empty
     * string.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * The trailing "@" character is not part of the user information and MUST
     * NOT be added.
     *
     * @return string The URI user information, in "username[:password]" format.
     */
    public function getUserInfo()
    {
        $result = $this->user;
        if (!empty($this->pass)) {
            $result .= sprintf(':%s', $this->pass);
        }

        return $result;
    }

    /**
     * Retrieve the host component of the URI.
     *
     * If no host is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.2.2.
     *
     * @see    http://tools.ietf.org/html/rfc3986#section-3.2.2
     * @return string The URI host.
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Duplicate with
     *
     * This method duplicate the current object and update a property with a given value before returning it
     *
     * @param string $property The property name to update
     * @param mixed  $value    The new property value
     *
     * @return StringUri
     */
    protected function duplicateWith(string $property, $value) : StringUri
    {
        $instance = clone $this;
        $instance->{$property} = $value;
        return $instance;
    }

    /**
     * Get standard scheme port
     *
     * This method return the standard scheme port for a given scheme
     *
     * @param mixed $scheme The scheme to retreive
     *
     * @return string|NULL
     */
    private function getStandardSchemePort(?string $scheme) : ?int
    {
        if (!empty($scheme) && isset(self::MAPPING[strtolower($scheme)])) {
            return self::MAPPING[strtolower($scheme)];
        }

        return null;
    }

    /**
     * Get scheme element
     *
     * This method return the scheme element of the url
     *
     * @return string
     */
    private function getSchemeElement() : string
    {
        $scheme = $this->scheme;
        if (!empty($scheme)) {
            $scheme .= ':';
        }

        return $scheme;
    }
}
