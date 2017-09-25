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
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Generic model persister
 *
 * This class is used as generic model persister
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericModelPersister implements EventSubscriberInterface
{
    /**
     * Model manager
     *
     * This property store the model manager
     *
     * @var ObjectManager
     */
    private $modelManager;

    /**
     * Construct
     *
     * The default GenericModelPersister constructor
     *
     * @param ObjectManager $modelManager The model manager to persist and store it
     *
     * @return void
     */
    public function __construct(ObjectManager $modelManager)
    {
            $this->modelManager = $modelManager;
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
                ['persistModel', 1024],
                ['storeModel', 512]
            ]
        ];
    }

    /**
     * Persist model
     *
     * This method persist a model
     *
     * @param ModelGeneratorEventInterface $event The generation event
     *
     * @return EventInterface
     */
    public function persistModel(ModelGeneratorEventInterface $event) : EventInterface
    {
        $this->modelManager->persist($event->getModel());
        return $event;
    }

    /**
     * Store model
     *
     * This method store a model
     *
     * @param ModelGeneratorEventInterface $event The generation event
     *
     * @return EventInterface
     */
    public function storeModel(ModelGeneratorEventInterface $event) : EventInterface
    {
        $this->modelManager->flush();
        return $event;
    }
}
