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
namespace Beotie\CoreBundle\Tests\Subscriber;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\Factory\ResponseDataFactoryInterface;
use Beotie\CoreBundle\Subscriber\GenericResponseDataAdder;
use Beotie\CoreBundle\Subscriber\GenericModelGenerator;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEventInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Response\Data\ResponseDataBagInterface;
use Beotie\CoreBundle\Response\Data\ResponseDataInterface;

/**
 * GenericResponseDataAdder test
 *
 * This class is used to validate the GenericResponseDataAdder class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataAdderTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the GenericModelPersister::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $dataFactory = $this->createMock(ResponseDataFactoryInterface::class);
        $instance = new GenericResponseDataAdder($dataFactory);

        $dataFactoryReflex = new \ReflectionProperty(GenericResponseDataAdder::class, 'responseDataFactory');
        $dataFactoryReflex->setAccessible(true);

        $this->assertSame($dataFactory, $dataFactoryReflex->getValue($instance));
    }

    /**
     * Test getSubscribedEvents
     *
     * This method validate the GenericModelPersister::getSubscribedEvents method
     *
     * @return void
     */
    public function testGetSubscribedEvents()
    {
        $expected = [
            GenericModelGenerator::EVENT_ON_DTO_VALID => [
                ['attachStoredModels', 0]
            ]
        ];

        $this->assertEquals($expected, call_user_func([GenericResponseDataAdder::class, 'getSubscribedEvents']));
    }

    /**
     * Test attachStoredModels
     *
     * This method validate the GenericModelPersister::attachStoredModels method
     *
     * @return void
     */
    public function testAttachStoredModels()
    {
        $dataPart = $this->createMock(ResponseDataInterface::class);
        $data = new \stdClass();

        $dataBag = $this->createMock(ResponseDataBagInterface::class);
        $dataBag->expects($this->once())
            ->method('addDataPart')
            ->with($this->identicalTo($dataPart));

        $response = $this->createMock(ResponseBagInterface::class);
        $response->expects($this->once())
            ->method('getDataBag')
            ->willReturn($dataBag);

        $event = $this->createMock(ModelGeneratorEventInterface::class);
        $event->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);
        $event->expects($this->once())
            ->method('getModel')
            ->willReturn($data);

        $dataFactory = $this->createMock(ResponseDataFactoryInterface::class);
        $dataFactory->expects($this->once())
            ->method('createFromData')
            ->with($this->identicalTo($data))
            ->willReturn($dataPart);

        $instance = new GenericResponseDataAdder($dataFactory);
        $this->assertSame($event, $instance->attachStoredModels($event));
    }
}
