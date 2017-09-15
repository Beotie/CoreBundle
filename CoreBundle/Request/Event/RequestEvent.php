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

use Symfony\Component\EventDispatcher\Event;
use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Request event
 *
 * This class is used as container behind a dispatch for request and response
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RequestEvent extends Event implements RequestEventInterface
{
    /**
     * Request
     *
     * This property store the process request
     *
     * @var RequestBagInterface
     */
    private $request;

    /**
     * Response
     *
     * This property store the process response
     *
     * @var ResponseBagInterface
     */
    private $response;

    /**
     * Construct
     *
     * The default RequestEvent constructor
     *
     * @param RequestBagInterface  $request  The process request
     * @param ResponseBagInterface $response The process response
     *
     * @return void
     */
    public function __construct(RequestBagInterface $request, ResponseBagInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get request
     *
     * This method return the base request
     *
     * @return RequestBagInterface
     */
    public function getRequest() : RequestBagInterface
    {
        return $this->request;
    }

    /**
     * Get response
     *
     * This method return the process response
     *
     * @return ResponseBagInterface
     */
    public function getResponse() : ResponseBagInterface
    {
        return $this->response;
    }
}
