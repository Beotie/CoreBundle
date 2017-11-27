<?php
namespace Beotie\CoreBundle\Request\Uri;

use Psr\Http\Message\UriInterface;

class StringUri implements UriInterface, PortMappingInterface
{
    protected $scheme = '';
    protected $path = '';
    protected $query = '';
    protected $fragment = '';
    protected $host = '';
    protected $port = null;
    protected $user = '';
    protected $password = '';

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
     * Return an instance with the specified scheme.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified scheme.
     *
     * Implementations MUST support the schemes "http" and "https" case
     * insensitively, and MAY accommodate other schemes if required.
     *
     * An empty scheme is equivalent to removing the scheme.
     *
     * @param string $scheme The scheme to use with the new instance.
     *
     * @return static A new instance with the specified scheme.
     * @throws \InvalidArgumentException for invalid or unsupported schemes.
     */
    public function withScheme($scheme)
    {
        return $this->duplicateWith('scheme', strtolower($scheme));
    }

    /**
     * Return an instance with the specified path.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified path.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * If the path is intended to be domain-relative rather than path relative then
     * it must begin with a slash ("/"). Paths not starting with a slash ("/")
     * are assumed to be relative to some base path known to the application or
     * consumer.
     *
     * Users can provide both encoded and decoded path characters.
     * Implementations ensure the correct encoding as outlined in getPath().
     *
     * @param string $path The path to use with the new instance.
     * @return static A new instance with the specified path.
     * @throws \InvalidArgumentException for invalid paths.
     */
    public function withPath($path)
    {
        return $this->duplicateWith('path', $path);
    }

    /**
     * Return an instance with the specified query string.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified query string.
     *
     * Users can provide both encoded and decoded query characters.
     * Implementations ensure the correct encoding as outlined in getQuery().
     *
     * An empty query string value is equivalent to removing the query string.
     *
     * @param string $query The query string to use with the new instance.
     * @return static A new instance with the specified query string.
     * @throws \InvalidArgumentException for invalid query strings.
     */
    public function withQuery($query)
    {
        return $this->duplicateWith('query', $query);
    }

    /**
     * Retrieve the scheme component of the URI.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.1.
     *
     * The trailing ":" character is not part of the scheme and MUST NOT be
     * added.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.1
     * @return string The URI scheme.
     */
    public function getScheme()
    {
        return strtolower($this->scheme);
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified URI fragment.
     *
     * Users can provide both encoded and decoded fragment characters.
     * Implementations ensure the correct encoding as outlined in getFragment().
     *
     * An empty fragment value is equivalent to removing the fragment.
     *
     * @param string $fragment The fragment to use with the new instance.
     * @return static A new instance with the specified fragment.
     */
    public function withFragment($fragment)
    {
        return $this->duplicateWith('fragment', $fragment);
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
     * @return static A new instance with the specified host.
     * @throws \InvalidArgumentException for invalid hostnames.
     */
    public function withHost($host)
    {
        return $this->duplicateWith('host', $host);
    }

    public function getAuthority()
    {}

    public function withPort($port)
    {}

    public function __toString()
    {}

    public function getPort()
    {}

    public function withUserInfo($user, $password = null)
    {}

    public function getPath()
    {}

    public function getFragment()
    {}

    public function getUserInfo()
    {}

    public function getHost()
    {}

    public function getQuery()
    {}

    private function duplicateWith(string $property, $value) : StringUri
    {
        $instance = clone $this;
        $instance->{$property} = $value;
        return $instance;
    }
}

