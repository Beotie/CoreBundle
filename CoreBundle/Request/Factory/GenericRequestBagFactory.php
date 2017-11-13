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
namespace Beotie\CoreBundle\Request\Factory;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Request\Event\RequestBagGenerationEvent;
use Beotie\CoreBundle\Request\Builder\GenericRequestBagBuilder;

/**
 * Generic request bag factory
 *
 * This class is used to generate a new RequestBag
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericRequestBagFactory implements RequestBagFactoryInterface
{
    /**
     * Event request generation
     *
     * This constant define the event throwed to start the request generation
     *
     * @var string
     */
    const EVENT_REQUEST_GENERATION = 'on_request_generate';

    /**
     * Server request
     *
     * This property store the server side request instance
     *
     * @var ServerRequestInterface
     */
    private $serverRequest;

    /**
     * Event dispatcher
     *
     * This property store the event dispatcher, in charge of the event dispatching for request bag generation
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Construct
     *
     * The default GenericRequestBagFactory constructor
     *
     * @param ServerRequestInterface   $serverRequest The server request
     * @param EventDispatcherInterface $dispatcher    The event dispatcher
     *
     * @return void
     */
    public function __construct(ServerRequestInterface $serverRequest, EventDispatcherInterface $dispatcher)
    {
        $this->serverRequest = $serverRequest;
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * Get request bag
     *
     * This method return a request bag
     *
     * @return RequestBagInterface
     */
    public function getRequestBag() : RequestBagInterface
    {
        $event = new RequestBagGenerationEvent($this->serverRequest, new GenericRequestBagBuilder());
        $this->eventDispatcher->dispatch(self::EVENT_REQUEST_GENERATION, $event);

        return $event->getRequestBagBuilder()->getRequestBag();
    }
}
