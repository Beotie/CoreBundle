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
        return $this->duplicateWith('scheme', $scheme);
    }

    public function withPath($path)
    {}

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

    private function duplicateWith(string $property, $value)
    {
        $instance = clone $this;
        $instance->{$property} = $value;
        return $instance;
    }
}

