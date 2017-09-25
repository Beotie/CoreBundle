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
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Response\Factory;

use Beotie\CoreBundle\Response\Data\ResponseDataInterface;
use Beotie\CoreBundle\Response\Data\GenericResponseData;
use Beotie\CoreBundle\Model\Mediator\Resolver\DataMediatorResolverInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Beotie\CoreBundle\Response\Factory\Event\ResponseDataGenerationEvent;
use Beotie\CoreBundle\Response\Factory\Event\ResponseDataGenerationEventInterface;
use Beotie\CoreBundle\Model\Mediator\DataMediatorInterface;

/**
 * Generic response data factory
 *
 * This class is used to create the instances of GenericResponseData
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataFactory extends EventDispatcher implements ResponseDataFactoryInterface
{
    const ON_CREATE_FROM_DATA = 'on_create_from_data';

    /**
     * Mediator resolver
     *
     * This property store a data mediator resolver to create a ResponseData from a given data
     *
     * @var DataMediatorResolverInterface
     */
    private $mediatorResolver;

    /**
     * Construct
     *
     * The default GenericResponseDataFactory constructor
     *
     * @param DataMediatorResolverInterface $mediatorResolver The data mediator resolver
     *
     * @return void
     */
    public function __construct(DataMediatorResolverInterface $mediatorResolver)
    {
        $this->mediatorResolver = $mediatorResolver;

        $this->addListener(self::ON_CREATE_FROM_DATA, [$this, 'createWithMediatorResolver'], 1024);
        $this->addListener(self::ON_CREATE_FROM_DATA, [$this, 'createWithMediator'], 0);
        $this->addListener(self::ON_CREATE_FROM_DATA, [$this, 'createWithoutMediator'], -1024);
    }

    /**
     * Get response data
     *
     * This method create and return a new instance of ResponseData
     *
     * @return ResponseDataInterface
     */
    public function getResponseData() : ResponseDataInterface
    {
        return new GenericResponseData();
    }

    /**
     * Create from data
     *
     * This method create a ResponseData based on a given data
     *
     * @param mixed $data The ResponseData data
     *
     * @return ResponseDataInterface
     * @throws \RuntimeException
     */
    public function createFromData($data) : ResponseDataInterface
    {
        $event = new ResponseDataGenerationEvent();
        $event->setData($data);

        $this->dispatch(self::ON_CREATE_FROM_DATA, $event);

        return $event->getResponseData();
    }

    /**
     * Create with MediatorResolver
     *
     * This method check if an ExternalMediator is applyable with the given data and create a ResponseData from it
     *
     * @param ResponseDataGenerationEventInterface $event The generation event
     *
     * @return                                      void
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod) This method is used as callback by constructor
     */
    protected function createWithMediatorResolver(ResponseDataGenerationEventInterface $event)
    {
        $data = $event->getData();
        if ($this->mediatorResolver->hasMediator($data)) {
            $mediator = $this->mediatorResolver->getMediator($data);
            $this->createFromMediator($mediator, $event);
        }
    }

    /**
     * Create with Mediator
     *
     * This method check if a Mediator is applyable with the given data and create a ResponseData from it
     *
     * @param ResponseDataGenerationEventInterface $event The generation event
     *
     * @return                                      void
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod) This method is used as callback by constructor
     */
    protected function createWithMediator(ResponseDataGenerationEventInterface $event)
    {
        $data = $event->getData();
        if ($data instanceof DataMediatorInterface) {
            $this->createFromMediator($data, $event);
        }
    }

    /**
     * Create without Mediator
     *
     * This method create a ResponseData from data without extended information
     *
     * @param ResponseDataGenerationEventInterface $event The generation event
     *
     * @return                                      void
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod) This method is used as callback by constructor
     */
    protected function createWithoutMediator(ResponseDataGenerationEventInterface $event)
    {
        $dataPart = $this->getResponseData();
        $dataPart->setData($event->getData());

        $event->setResponseData($dataPart);
    }

    /**
     * Create from mediator
     *
     * This method create a ResponseData regardless of the mediator origin
     *
     * @param DataMediatorInterface                $mediator The data mediator
     * @param ResponseDataGenerationEventInterface $event    The original event
     *
     * @return void
     */
    private function createFromMediator(
        DataMediatorInterface $mediator,
        ResponseDataGenerationEventInterface $event
    ) {
        $data = $event->getData();

        $dataPart = $this->getResponseData();

        $dataPart->setType($mediator->getDataType($data))
            ->setId($mediator->getDataId($data))
            ->setAttributes($mediator->getDataAttrbutes($data))
            ->setRelationships($mediator->getDataRelationships($data))
            ->setLinks($mediator->getDataLinks($data))
            ->setData($data);

        $event->setResponseData($dataPart);
    }
}
