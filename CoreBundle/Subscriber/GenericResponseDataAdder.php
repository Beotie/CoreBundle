<?php
declare(strict_types=1);
/**
 * This file is part of beotie/user_bundle
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.1
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Beotie\CoreBundle\Event\EventInterface;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEventInterface;
use Beotie\CoreBundle\Response\Factory\ResponseDataFactoryInterface;

/**
 * Generic response data adder
 *
 * This class is used as generic response data adder. It attach data part to the response
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataAdder implements EventSubscriberInterface
{
    /**
     * Response data factory
     *
     * This property store a ReponseDataFactory used to create new ResponseData
     *
     * @var ResponseDataFactoryInterface
     */
    private $responseDataFactory;

    /**
     * Construct
     *
     * The default GenericModelGenerator constructor
     *
     * @param ResponseDataFactoryInterface $responseDataFactory The data part factory
     *
     * @return void
     */
    public function __construct(ResponseDataFactoryInterface $responseDataFactory)
    {
        $this->responseDataFactory = $responseDataFactory;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            GenericModelGenerator::EVENT_ON_DTO_VALID => [
                ['attachStoredModels', 0]
            ]
        ];
    }

    /**
     * Attach stored model
     *
     * This method attach the stored data element to the response
     *
     * @param ModelGeneratorEventInterface $event The generation event
     *
     * @return EventInterface
     */
    public function attachStoredModels(ModelGeneratorEventInterface $event) : EventInterface
    {
        $dataPart = $this->responseDataFactory->createFromData($event->getModel());

        $event->getResponse()
            ->getDataBag()
            ->addDataPart($dataPart);

        return $event;
    }
}
