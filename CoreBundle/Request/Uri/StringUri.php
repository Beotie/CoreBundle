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

    public function withQuery($query)
    {}

    public function getScheme()
    {}

    public function withFragment($fragment)
    {}

    public function withHost($host)
    {}

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

