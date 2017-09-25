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

use Beotie\CoreBundle\Request\Event\RequestEventInterface;
use Beotie\CoreBundle\Request\Facade\RequestProcessorInterface;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Generic model generator
 *
 * This class is used as generic model generator. It use model factory to generate newmodel instances
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericModelGenerator extends EventDispatcher
{
    /**
     * Event generate model
     *
     * This constant indicate the event name that dispatch model generation
     *
     * @var string
     */
    const EVENT_GENERATE_MODEL = 'event_generate_model';

    /**
     * Event on dto valid
     *
     * This constant indicate the event name triggered in case of validated DTO
     *
     * @var string
     */
    const EVENT_ON_DTO_VALID = 'event_on_dto_is_valid';

    /**
     * Event on dto invalid
     *
     * This constant indicate the event name triggered in case of invalidated DTO
     *
     * @var string
     */
    const EVENT_ON_DTO_INVALID = 'event_on_dto_is_invalid';

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
            RequestProcessorInterface::EVENT_POST_RESOURCE => [
                ['generateModel', 1024]
            ],
            RequestProcessorInterface::EVENT_POST_RESOURCES => [
                ['generateModels', 1024]
            ]
        ];
    }

    /**
     * Generate models
     *
     * This method generate a set of new model, register and create a response
     *
     * @param RequestEventInterface $requestEvent The original request event
     *
     * @return void
     * @throws \RuntimeException
     */
    public function generateModels(RequestEventInterface $requestEvent)
    {
        $data = $requestEvent->getRequest()->getData();

        if (!is_array($data)) {
            throw new \RuntimeException('The provided data must be an array');
        }
        if (empty($data)) {
            throw new \RuntimeException('A data must be provided');
        }

        $response = $requestEvent->getResponse();
        foreach ($data as $dataElement) {
            $generatorEvent = new ModelGeneratorEvent($dataElement, $response);
            $this->dispatch(self::EVENT_GENERATE_MODEL, $generatorEvent);
        }
    }

    /**
     * Generate model
     *
     * This method generate a new model, register and create a response
     *
     * @param RequestEventInterface $requestEvent The original request event
     *
     * @return void
     * @throws \RuntimeException
     */
    public function generateModel(RequestEventInterface $requestEvent)
    {
        $data = $requestEvent->getRequest()->getData();

        if ($data === null) {
            throw new \RuntimeException('A data must be provided');
        }

        $generatorEvent = new ModelGeneratorEvent($data, $requestEvent->getResponse());
        $this->dispatch(self::EVENT_GENERATE_MODEL, $generatorEvent);
    }
}
