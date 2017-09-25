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
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Tests\Response\Factory;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\Factory\GenericResponseDataFactory;
use Beotie\CoreBundle\Model\Mediator\Resolver\DataMediatorResolverInterface;
use Beotie\CoreBundle\Response\Data\GenericResponseData;
use Beotie\CoreBundle\Model\Mediator\ExternalDataMediatorInterface;

/**
 * GenericResponseDataFactory test
 *
 * This class is used to validate the GenericResponseDataFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataFactoryTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the GenericResponseDataFactory::_construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $mediatorResolver = $this->createMock(DataMediatorResolverInterface::class);
        $instance = new GenericResponseDataFactory($mediatorResolver);

        $reflexMediator = new \ReflectionProperty(GenericResponseDataFactory::class, 'mediatorResolver');
        $reflexMediator->setAccessible(true);

        $this->assertSame($mediatorResolver, $reflexMediator->getValue($instance));

        $listeners = $instance->getListeners(GenericResponseDataFactory::ON_CREATE_FROM_DATA);

        $expectedListeners = [
            [[$instance, 'createWithMediatorResolver'], 1024],
            [[$instance, 'createWithMediator'], 0],
            [[$instance, 'createWithoutMediator'], -1024]
        ];

        foreach ($expectedListeners as $listener) {
            $this->assertContains($listener[0], $listeners);

            $prioritisedListener = null;
            foreach ($listeners as $registeredListener) {
                if ($registeredListener == $listener[0]) {
                    $prioritisedListener = $registeredListener;
                }
            }

            $this->assertEquals(
                $listener[1],
                $instance->getListenerPriority(
                    GenericResponseDataFactory::ON_CREATE_FROM_DATA,
                    $prioritisedListener
                )
            );
        }
    }

    /**
     * Test getResponseData
     *
     * This method validate the GenericResponseDataFactory::getResponseData method
     *
     * @return void
     */
    public function testGetResponseData()
    {
        $mediatorResolver = $this->createMock(DataMediatorResolverInterface::class);
        $instance = new GenericResponseDataFactory($mediatorResolver);

        $this->assertInstanceOf(GenericResponseData::class, $instance->getResponseData());
    }

    /**
     * Test createWithMediatorResolver
     *
     * This method validate the GenericResponseDataFactory::createWithMediatorResolver method
     *
     * @return void
     */
    public function testCreateWithMediatorResolver()
    {
        $data = new \stdClass();

        $mediator = $this->createMock(ExternalDataMediatorInterface::class);
        $mediator->expects($this->once())
            ->method('getDataType')
            ->with($this->identicalTo($data))
            ->willReturn('DATA_TYPE');
        $mediator->expects($this->once())
            ->method('getDataId')
            ->with($this->identicalTo($data))
            ->willReturn('43c1eab9-a5a0-4e6e-a6de-08bfa021a1f4');
        $mediator->expects($this->once())
            ->method('getDataAttrbutes')
            ->with($this->identicalTo($data))
            ->willReturn(['attr' => 'value']);
        $mediator->expects($this->once())
            ->method('getDataRelationships')
            ->with($this->identicalTo($data))
            ->willReturn(['rel' => 'value']);
        $mediator->expects($this->once())
            ->method('getDataLinks')
            ->with($this->identicalTo($data))
            ->willReturn(['link' => 'value']);

        $mediatorResolver = $this->createMock(DataMediatorResolverInterface::class);
        $mediatorResolver->expects($this->once())
            ->method('hasMediator')
            ->with($this->identicalTo($data))
            ->willReturn(true);
        $mediatorResolver->expects($this->once())
            ->method('getMediator')
            ->with($this->identicalTo($data))
            ->willReturn($mediator);

        $instance = new GenericResponseDataFactory($mediatorResolver);

        $responseData = $instance->createFromData($data);

        $this->assertSame($data, $responseData->getData());
        $this->assertEquals('DATA_TYPE', $responseData->getType());
        $this->assertEquals('43c1eab9-a5a0-4e6e-a6de-08bfa021a1f4', $responseData->getId());
        $this->assertEquals(['attr' => 'value'], $responseData->getAttributes());
        $this->assertEquals(['rel' => 'value'], $responseData->getRelationships());
        $this->assertEquals(['link' => 'value'], $responseData->getLinks());
    }

    /**
     * Test createWithMediator
     *
     * This method validate the GenericResponseDataFactory::createWithMediator method
     *
     * @return void
     */
    public function testCreateWithMediator()
    {
        $mediator = $this->createMock(ExternalDataMediatorInterface::class);
        $mediator->expects($this->once())
            ->method('getDataType')
            ->with($this->identicalTo($mediator))
            ->willReturn('DATA_TYPE');
        $mediator->expects($this->once())
            ->method('getDataId')
            ->with($this->identicalTo($mediator))
            ->willReturn('43c1eab9-a5a0-4e6e-a6de-08bfa021a1f4');
        $mediator->expects($this->once())
            ->method('getDataAttrbutes')
            ->with($this->identicalTo($mediator))
            ->willReturn(['attr' => 'value']);
        $mediator->expects($this->once())
            ->method('getDataRelationships')
            ->with($this->identicalTo($mediator))
            ->willReturn(['rel' => 'value']);
        $mediator->expects($this->once())
            ->method('getDataLinks')
            ->with($this->identicalTo($mediator))
            ->willReturn(['link' => 'value']);

        $mediatorResolver = $this->createMock(DataMediatorResolverInterface::class);
        $mediatorResolver->expects($this->once())
            ->method('hasMediator')
            ->with($this->identicalTo($mediator))
            ->willReturn(false);
        $mediatorResolver->expects($this->never())
            ->method('getMediator');

        $instance = new GenericResponseDataFactory($mediatorResolver);

        $responseData = $instance->createFromData($mediator);

        $this->assertSame($mediator, $responseData->getData());
        $this->assertEquals('DATA_TYPE', $responseData->getType());
        $this->assertEquals('43c1eab9-a5a0-4e6e-a6de-08bfa021a1f4', $responseData->getId());
        $this->assertEquals(['attr' => 'value'], $responseData->getAttributes());
        $this->assertEquals(['rel' => 'value'], $responseData->getRelationships());
        $this->assertEquals(['link' => 'value'], $responseData->getLinks());
    }

    /**
     * Test createWithoutMediator
     *
     * This method validate the GenericResponseDataFactory::createWithoutMediator method
     *
     * @return void
     */
    public function testCreateWithoutMediator()
    {
        $data = new \stdClass();

        $mediatorResolver = $this->createMock(DataMediatorResolverInterface::class);
        $mediatorResolver->expects($this->once())
            ->method('hasMediator')
            ->with($this->identicalTo($data))
            ->willReturn(false);
        $mediatorResolver->expects($this->never())
            ->method('getMediator');

        $instance = new GenericResponseDataFactory($mediatorResolver);

        $responseData = $instance->createFromData($data);

        $this->assertSame($data, $responseData->getData());
        $this->assertEquals('', $responseData->getType());
        $this->assertNull($responseData->getId());
        $this->assertEquals([], $responseData->getAttributes());
        $this->assertEquals([], $responseData->getRelationships());
        $this->assertEquals([], $responseData->getLinks());
    }
}
