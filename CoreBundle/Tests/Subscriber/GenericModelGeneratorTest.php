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

use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Request\Event\RequestEventInterface;
use Beotie\CoreBundle\Request\Facade\RequestProcessorInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Subscriber\GenericModelGenerator;
use PHPUnit\Framework\TestCase;

/**
 * GenericModelGenerator test
 *
 * This class is used to validate the GenericModelGenerator class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericModelGeneratorTest extends TestCase
{
    /**
     * Test getSubscribedEvents
     *
     * This method validate the GenericModelGenerator::getSubscribedEvents method
     *
     * @return void
     */
    public function testGetSubscribedEvents()
    {
        $expectedResult = [
            RequestProcessorInterface::EVENT_POST_RESOURCE => [
                ['generateModel', 1024]
            ],
            RequestProcessorInterface::EVENT_POST_RESOURCES => [
                ['generateModels', 1024]
            ]
        ];

        $this->assertEquals(
            $expectedResult,
            call_user_func([GenericModelGenerator::class, 'getSubscribedEvents'])
        );
    }

    /**
     * Test generateModels
     *
     * This method validate the GenericModelGenerator::generateModels method
     *
     * @return void
     */
    public function testGenerateModels()
    {
        $dtos = [
            new \stdClass(),
            new \stdClass(),
            new \stdClass()
        ];

        $instance = new GenericModelGenerator();

        $request = $this->createMock(RequestBagInterface::class);
        $request->expects($this->once())
            ->method('getData')
            ->willReturn($dtos);

        $response = $this->createMock(ResponseBagInterface::class);

        $event = $this->createMock(RequestEventInterface::class);
        $event->expects($this->once())
            ->method('getRequest')
            ->willReturn($request);
        $event->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);

        $instance->generateModels($event);
    }

    /**
     * Models data provider
     *
     * This method return a set of data to validate the GenericModelGenerator::generateModels method
     *
     * @return [[null|array]]
     */
    public function modelsDataProvider()
    {
        return [[null], [[]]];
    }

    /**
     * Test generateModels without data
     *
     * This method validate the GenericModelGenerator::generateModels method
     *
     * @param mixed $data The data content
     *
     * @return       void
     * @dataProvider modelsDataProvider
     */
    public function testGenerateModelsWithoutData($data)
    {
        $this->expectException(\RuntimeException::class);

        $instance = new GenericModelGenerator();

        $request = $this->createMock(RequestBagInterface::class);
        $request->expects($this->once())
            ->method('getData')
            ->willReturn($data);

        $event = $this->createMock(RequestEventInterface::class);
        $event->expects($this->once())
            ->method('getRequest')
            ->willReturn($request);

        $instance->generateModels($event);
    }

    /**
     * Test generateModel
     *
     * This method validate the GenericModelGenerator::generateModel method
     *
     * @return void
     */
    public function testGenerateModel()
    {
        $instance = new GenericModelGenerator();

        $request = $this->createMock(RequestBagInterface::class);
        $request->expects($this->once())
            ->method('getData')
            ->willReturn(new \stdClass());

        $response = $this->createMock(ResponseBagInterface::class);

        $event = $this->createMock(RequestEventInterface::class);
        $event->expects($this->once())
            ->method('getRequest')
            ->willReturn($request);
        $event->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);

        $instance->generateModel($event);
    }

    /**
     * Test generateModel without data
     *
     * This method validate the GenericModelGenerator::generateModel method
     *
     * @return void
     */
    public function testGenerateModelWithoutData()
    {
        $this->expectException(\RuntimeException::class);

        $instance = new GenericModelGenerator();

        $request = $this->createMock(RequestBagInterface::class);
        $request->expects($this->once())
            ->method('getData')
            ->willReturn(null);

        $event = $this->createMock(RequestEventInterface::class);
        $event->expects($this->once())
            ->method('getRequest')
            ->willReturn($request);

        $instance->generateModel($event);
    }
}
