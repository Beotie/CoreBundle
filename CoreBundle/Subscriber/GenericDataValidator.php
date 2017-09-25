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
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEventInterface;
use Beotie\CoreBundle\Event\EventInterface;
use Beotie\CoreBundle\Model\Factory\ModelFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Generic data validator
 *
 * This class is used as generic data validator. It dispatch GenericModelGenerator::EVENT_ON_DTO_VALID
 * or GenericModelGenerator::EVENT_ON_DTO_INVALID
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDataValidator implements EventSubscriberInterface
{
    /**
     * Model factory
     *
     * This property store a model factory to allow model creation
     *
     * @var ModelFactoryInterface
     */
    private $modelFactory;

    /**
     * Construct
     *
     * The default GenericDataValidator constructor
     *
     * @param ModelFactoryInterface $modelFactory The model factory used to create new model instances
     *
     * @return void
     */
    public function __construct(ModelFactoryInterface $modelFactory)
    {
        $this->modelFactory = $modelFactory;
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
            GenericModelGenerator::EVENT_GENERATE_MODEL => [
                ['validateDataTransfertObject', 0]
            ]
        ];
    }

    /**
     * Validate data transfert object
     *
     * This method validate the given data transfert object. It dispatch GenericModelGenerator::EVENT_ON_DTO_VALID
     * or GenericModelGenerator::EVENT_ON_DTO_INVALID
     *
     * @param ModelGeneratorEventInterface $event      The generation event
     * @param string                       $eventName  The throwed event name
     * @param EventDispatcherInterface     $dispatcher The event dispatcher
     *
     * @return EventInterface
     */
    public function validateDataTransfertObject(
        ModelGeneratorEventInterface $event,
        string $eventName,
        EventDispatcherInterface $dispatcher
    ) : EventInterface {
        unset($eventName);

        if ($this->modelFactory->isValid($event->getDataTransfertObject())) {
            return $dispatcher->dispatch(GenericModelGenerator::EVENT_ON_DTO_VALID, $event);
        }

        return $dispatcher->dispatch(GenericModelGenerator::EVENT_ON_DTO_INVALID, $event);
    }
}
