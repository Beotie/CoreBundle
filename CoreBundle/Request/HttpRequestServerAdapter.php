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
namespace Beotie\CoreBundle\Request;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Request\File\Factory\EmbeddedFileFactoryInterface;
use CoreBundle\Request\HttpComponent as Component;

/**
 * Http request server adapter
 *
 * This class is used to implement the PSR7 over symfony Request instance
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class HttpRequestServerAdapter implements ServerRequestInterface
{
    use Component\CookieComponent,
        Component\AttributeComponent,
        Component\DuplicationComponent,
        Component\HeaderComponent,
        Component\QueryComponent,
        Component\FileComponent,
        Component\BodyComponent;

    /**
     * Http request
     *
     * The base symfony http request
     *
     * @var Request
     */
    private $httpRequest;

    /**
     * Construct
     *
     * The base HttpRequestServerAdapter constructor
     *
     * @param Request                      $httpRequest The base symfony request instance
     * @param EmbeddedFileFactoryInterface $fileFactory The EbeddedUploadFile factory
     *
     * @return void
     */
    public function __construct(Request $httpRequest, EmbeddedFileFactoryInterface $fileFactory)
    {
        $this->httpRequest = $httpRequest;
        $this->fileFactory = $fileFactory;
    }

    /**
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     *
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the returned
     *   request.
     * - If the Host header is missing or empty, and the new URI does not contain a
     *   host component, this method MUST NOT update the Host header in the returned
     *   request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @param UriInterface $uri          New request URI to use.
     * @param bool         $preserveHost Preserve the original state of the Host header.
     *
     * @link   http://tools.ietf.org/html/rfc3986#section-4.3
     * @return static
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $httpRequest = clone $this->httpRequest;
        $parameters = array_merge($httpRequest->query->all(), $httpRequest->request->all());
        $httpRequest->create(
            $uri,
            $httpRequest->getMethod(),
            $parameters,
            $httpRequest->cookies->all(),
            $httpRequest->files->all(),
            $httpRequest->server->all(),
            $httpRequest->getContent()
        );

        $this->updateHostFromUri($httpRequest, $uri, !$preserveHost);

        return new static($httpRequest);
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod()
    {
        return $this->httpRequest->getMethod();
    }

    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget()
    {
        return $this->httpRequest->getRequestUri();
    }

    /**
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @param mixed $requestTarget the request target
     *
     * @link   http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     * @return static
     */
    public function withRequestTarget($requestTarget)
    {
        $httpRequest = clone $this->httpRequest;
        $parameters = array_merge($httpRequest->query->all(), $httpRequest->request->all());
        $httpRequest->create(
            $requestTarget,
            $httpRequest->getMethod(),
            $parameters,
            $httpRequest->cookies->all(),
            $httpRequest->files->all(),
            $httpRequest->server->all(),
            $httpRequest->getContent()
        );

        return new static($httpRequest);
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     *
     * @return static
     */
    public function withProtocolVersion($version)
    {
        if (!preg_match('/([0-9]+\.?)+/', $version)) {
            throw new \RuntimeException(
                'The version string MUST contain only the HTTP version number (e.g., "1.1", "1.0").'
            );
        }

        return $this->withHeader('SERVER_PROTOCOL', $version);
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion()
    {
        return $this->httpRequest->server->get('SERVER_PROTOCOL');
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param string $method Case-sensitive method.
     *
     * @throws \InvalidArgumentException for invalid HTTP methods.
     * @return static
     */
    public function withMethod($method)
    {
        $httpRequest = $this->httpRequest;
        $parameters = array_merge($httpRequest->query->all(), $httpRequest->request->all());

        return new static(
            $httpRequest->create(
                $this->getUri(),
                $method,
                $parameters,
                $httpRequest->cookies->all(),
                $httpRequest->files->all(),
                $httpRequest->server->all(),
                $httpRequest->getContent()
            )
        );
    }

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @return array
     */
    public function getServerParams()
    {
        return $this->httpRequest->server->all();
    }

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @link   http://tools.ietf.org/html/rfc3986#section-4.3
     * @return UriInterface Returns a UriInterface instance
     *     representing the URI of the request.
     */
    public function getUri()
    {
        return $this->httpRequest->getUri();
    }

    /**
     * Update host from URI
     *
     * This method update the request, accordingly with the given uri host if exist. If the request already
     * have defined a host, this method does not update the request with the uri host as long as the force
     * parameter is set to false.
     *
     * @param Request $request The request to update
     * @param string  $uri     The uri whence extract the host
     * @param bool    $force   Indicate the request header MUST be override if the uri contain host
     *
     * @return void
     */
    private function updateHostFromUri(Request $request, string $uri, bool $force)
    {
        $uriHostComponent = parse_url($uri, PHP_URL_HOST);
        if ($uriHostComponent === false) {
            return;
        }

        $host = $this->httpRequest->getHost();

        if (empty($host) && !empty($uriHostComponent)) {
            $request->headers->set('HOST', $uriHostComponent);
            return;
        }

        if (!$force) {
            return;
        }

        if (!empty($uriHostComponent)) {
            $request->headers->set('HOST', $uriHostComponent);
        }

        return;
    }
}
