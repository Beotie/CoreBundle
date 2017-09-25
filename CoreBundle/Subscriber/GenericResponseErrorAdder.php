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
use Beotie\CoreBundle\Model\Factory\ModelFactoryInterface;
use Beotie\CoreBundle\Response\Factory\ResponseErrorFactoryInterface;

/**
 * Generic response error adder
 *
 * This class is used as generic response error adder. It attach error part to the response
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorAdder implements EventSubscriberInterface
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
     * Response error factory
     *
     * This property store a ResponseErrorFactory used to create new ResponseError
     *
     * @var ResponseErrorFactoryInterface
     */
    private $responseErrorFactory;

    /**
     * Construct
     *
     * The default GenericResponseErrorAdder constructor
     *
     * @param ModelFactoryInterface         $modelFactory         The model factory used to create new model instances
     * @param ResponseErrorFactoryInterface $responseErrorFactory The error part factory
     *
     * @return void
     */
    public function __construct(
        ModelFactoryInterface $modelFactory,
        ResponseErrorFactoryInterface $responseErrorFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->responseErrorFactory = $responseErrorFactory;
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
            GenericModelGenerator::EVENT_ON_DTO_INVALID => [
                ['attachValidationErrors', 0]
            ]
        ];
    }

    /**
     * Attach validation errors
     *
     * This method attach the validation errors to the response
     *
     * @param ModelGeneratorEventInterface $event The generation event
     *
     * @return EventInterface
     */
    public function attachValidationErrors(ModelGeneratorEventInterface $event) : EventInterface
    {
        $response = $event->getResponse();
        $data = $event->getDataTransfertObject();
        $errors = $this->modelFactory->getValidationErrors($data);

        foreach ($errors as $error) {
            $errorPart = $this->responseErrorFactory->getResponseError();
            $errorPart->setData($data)
                ->setDataPartLocator($error->getPropertyPath())
                ->setDataValue($error->getInvalidValue())
                ->setMessage($error->getMessage());

            if ($error->getCode()) {
                $errorPart->setErrorCode($error->getCode());
            }

            $response->getErrorBag()->addErrorPart($errorPart);
        }

        return $event;
    }
}
