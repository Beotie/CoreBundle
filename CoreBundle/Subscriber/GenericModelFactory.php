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

/**
 * Generic model factory
 *
 * This class is used as generic model factory. It create a model from a DataTransfertObject
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericModelFactory implements EventSubscriberInterface
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
     * The default GenericModelFactory constructor
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
            GenericModelGenerator::EVENT_ON_DTO_VALID => [
                ['createModel', 2048]
            ]
        ];
    }

    /**
     * Create model
     *
     * This method generate a model from a data transfert object
     *
     * @param ModelGeneratorEventInterface $event The generation event
     *
     * @return EventInterface
     */
    public function createModel(ModelGeneratorEventInterface $event) : EventInterface
    {
        $model = $this->modelFactory->buildModel($event->getDataTransfertObject());
        $event->setModel($model);
        return $event;
    }
}
