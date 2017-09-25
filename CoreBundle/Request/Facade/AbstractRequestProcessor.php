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
namespace Beotie\CoreBundle\Request\Facade;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Response\Factory\ResponseBagFactoryInterface;
use Beotie\CoreBundle\Request\Event\Factory\RequestEventFactoryInterface;

/**
 * Abstract request processor
 *
 * This class is used to manage the request process
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractRequestProcessor implements RequestProcessorInterface
{
    /**
     * ResponseBag factory
     *
     * This property store a ResponseBagFactory instance to generate the process responses
     *
     * @var ResponseBagFactoryInterface
     */
    private $responseBagFactory;

    /**
     * Request event factory
     *
     * This property store a RequestEventFactory instance to generate the process event
     *
     * @var RequestEventFactoryInterface
     */
    private $requestEventFactory;

    /**
     * Event dispatcher
     *
     * This property store the event dispatcher to dispatch RequestEvents
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Construct
     *
     * The default AbstractRequestProcessor constructor
     *
     * @param ResponseBagFactoryInterface  $responseBagFactory  The ResponseBagFactory
     * @param RequestEventFactoryInterface $requestEventFactory The RequestEventFactory
     * @param EventDispatcherInterface     $eventDispatcher     The EventDispatcher
     *
     * @return void
     */
    public function __construct(
        ResponseBagFactoryInterface $responseBagFactory,
        RequestEventFactoryInterface $requestEventFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->responseBagFactory = $responseBagFactory;
        $this->requestEventFactory = $requestEventFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get resources
     *
     * This method process a multiple resource loading request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function getResources(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_GET_RESOURCES);
    }

    /**
     * Get resource
     *
     * This method process a resource loading request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function getResource(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_GET_RESOURCE);
    }

    /**
     * Post resources
     *
     * This method process a multiple resource creation request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function postResources(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_POST_RESOURCES);
    }

    /**
     * Post resource
     *
     * This method process a resource creation request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function postResource(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_POST_RESOURCE);
    }

    /**
     * Put resources
     *
     * This method process a resource replacement request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function putResource(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_PUT_RESOURCE);
    }

    /**
     * Patch resources
     *
     * This method process a resource partial modification request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function patchResource(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_PATCH_RESOURCE);
    }

    /**
     * Delete resources
     *
     * This method process a resource deletion request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function deleteResource(RequestBagInterface $request) : ResponseBagInterface
    {
        return $this->processEvent($request, self::EVENT_DELETE_RESOURCE);
    }

    /**
     * Process event
     *
     * This method process an event by dispatching it behind the registered subscriber and listeners
     *
     * @param RequestBagInterface $request   The process request
     * @param string              $eventName The event name to dispatch
     *
     * @return ResponseBagInterface
     */
    private function processEvent(RequestBagInterface $request, string $eventName) : ResponseBagInterface
    {
        $event = $this->requestEventFactory->getRequestEvent($request, $this->responseBagFactory->getResponseBag());

        $this->eventDispatcher->dispatch($eventName, $event);

        return $event->getResponse();
    }
}
