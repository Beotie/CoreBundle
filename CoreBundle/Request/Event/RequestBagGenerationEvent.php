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
namespace Beotie\CoreBundle\Request\Event;

use Beotie\CoreBundle\Request\Builder\RequestBagBuilderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Request bag generation event
 *
 * This class is used as RequestBag generation event
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RequestBagGenerationEvent extends Event implements RequestBagGenerationEventInterface
{
    /**
     * Server request
     *
     * This property store the server request
     *
     * @var ServerRequestInterface
     */
    private $serverRequest;

    /**
     * Request bag builder
     *
     * This property store the request bag builder
     *
     * @var RequestBagBuilderInterface
     */
    private $requestBagBuilder;

    /**
     * Construct
     *
     * The default RequestBagGenerationEvent constructor
     *
     * @param ServerRequestInterface     $serverRequest  The server request
     * @param RequestBagBuilderInterface $requestBuilder The request bag builder
     *
     * @return void
     */
    public function __construct(ServerRequestInterface $serverRequest, RequestBagBuilderInterface $requestBuilder)
    {
        $this->serverRequest = $serverRequest;
        $this->requestBagBuilder = $requestBuilder;
    }

    /**
     * Get server request
     *
     * This method return the original server request
     *
     * @return ServerRequestInterface
     */
    public function getServerRequest() : ServerRequestInterface
    {
        return $this->serverRequest;
    }

    /**
     * Get request bag builder
     *
     * This method return the current request bag builder
     *
     * @return RequestBagBuilderInterface
     */
    public function getRequestBagBuilder() : RequestBagBuilderInterface
    {
        return $this->requestBagBuilder;
    }
}
