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
use Beotie\CoreBundle\Subscriber\GenericModelGenerator;
use Beotie\CoreBundle\Subscriber\GenericResponseErrorAdder;
use Beotie\CoreBundle\Model\Factory\ModelFactoryInterface;
use Beotie\CoreBundle\Response\Factory\ResponseErrorFactoryInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEvent;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Beotie\CoreBundle\Response\Error\ResponseErrorInterface;
use Beotie\CoreBundle\Response\Error\ResponseErrorBagInterface;

/**
 * GenericResponseErrorAdder test
 *
 * This class is used to validate the GenericResponseErrorAdder class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorAdderTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the GenericResponseErrorAdder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $modelFactory = $this->createMock(ModelFactoryInterface::class);
        $errorFactory = $this->createMock(ResponseErrorFactoryInterface::class);
        $instance = new GenericResponseErrorAdder($modelFactory, $errorFactory);

        $modelFactoryReflex = new \ReflectionProperty(GenericResponseErrorAdder::class, 'modelFactory');
        $modelFactoryReflex->setAccessible(true);
        $this->assertSame($modelFactory, $modelFactoryReflex->getValue($instance));

        $errorFactoryReflex = new \ReflectionProperty(GenericResponseErrorAdder::class, 'responseErrorFactory');
        $errorFactoryReflex->setAccessible(true);
        $this->assertSame($errorFactory, $errorFactoryReflex->getValue($instance));
    }

    /**
     * Test getSubscribedEvents
     *
     * This method validate the GenericResponseErrorAdder::getSubscribedEvents method
     *
     * @return void
     */
    public function testGetSubscribedEvents()
    {
        $expected = [
            GenericModelGenerator::EVENT_ON_DTO_INVALID => [
                ['attachValidationErrors', 0]
            ]
        ];

        $this->assertEquals($expected, call_user_func([GenericResponseErrorAdder::class, 'getSubscribedEvents']));
    }

    /**
     * Test attachValidationErrors
     *
     * This method validate the GenericResponseErrorAdder::attachValidationErrors method
     *
     * @return void
     */
    public function testAttachValidationErrors()
    {
        $data = new \stdClass();
        $response = $this->createMock(ResponseBagInterface::class);
        $event = $this->createMock(ModelGeneratorEvent::class);
        $event->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);
        $event->expects($this->once())
            ->method('getDataTransfertObject')
            ->willReturn($data);

        $errorList = $this->getErrorList();

        $modelFactory = $this->createMock(ModelFactoryInterface::class);
        $modelFactory->expects($this->once())
            ->method('getValidationErrors')
            ->willReturn($errorList);

        $errorParts = $this->getErrorParts($data);

        $errorFactory = $this->createMock(ResponseErrorFactoryInterface::class);
        $errorFactory->expects($this->exactly(2))
            ->method('getResponseError')
            ->willReturnOnConsecutiveCalls($errorParts[0], $errorParts[1]);

        $errorBag = $this->createMock(ResponseErrorBagInterface::class);
        $response->expects($this->exactly(2))
            ->method('getErrorBag')
            ->willReturn($errorBag);
        $errorBag->expects($this->exactly(2))
            ->method('addErrorPart')
            ->withConsecutive($this->identicalTo($errorParts[0]), $this->identicalTo($errorParts[1]));

        $instance = new GenericResponseErrorAdder($modelFactory, $errorFactory);

        $this->assertSame($event, $instance->attachValidationErrors($event));
    }

    /**
     * Get error parts
     *
     * This method return a set of error parts
     *
     * @param \stdClass $data The event data
     *
     * @return [\PHPUnit_Framework_MockObject_MockObject]
     */
    private function getErrorParts(\stdClass $data)
    {
        $errorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $errorParts[0]->expects($this->once())
            ->method('setData')
            ->with($this->identicalTo($data))
            ->willReturn($errorParts[0]);
        $errorParts[0]->expects($this->once())
            ->method('setDataPartLocator')
            ->with($this->equalTo('property["path_0"]'))
            ->willReturn($errorParts[0]);
        $errorParts[0]->expects($this->once())
            ->method('setDataValue')
            ->with($this->equalTo('val_0'))
            ->willReturn($errorParts[0]);
        $errorParts[0]->expects($this->once())
            ->method('setMessage')
            ->with($this->equalTo('message_0'))
            ->willReturn($errorParts[0]);

        $errorParts[1]->expects($this->once())
            ->method('setData')
            ->with($this->identicalTo($data))
            ->willReturn($errorParts[1]);
        $errorParts[1]->expects($this->once())
            ->method('setDataPartLocator')
            ->with($this->equalTo('property["path_1"]'))
            ->willReturn($errorParts[1]);
        $errorParts[1]->expects($this->once())
            ->method('setDataValue')
            ->with($this->equalTo('val_1'))
            ->willReturn($errorParts[1]);
        $errorParts[1]->expects($this->once())
            ->method('setMessage')
            ->with($this->equalTo('message_1'))
            ->willReturn($errorParts[1]);
        $errorParts[1]->expects($this->once())
            ->method('setErrorCode')
            ->with($this->equalTo('1'))
            ->willReturn($errorParts[1]);

        return $errorParts;
    }

    /**
     * Get error list
     *
     * This method return a set of error into a list
     *
     * @return ConstraintViolationList
     */
    private function getErrorList()
    {
        $errors = [
            $this->createMock(ConstraintViolationInterface::class),
            $this->createMock(ConstraintViolationInterface::class)
        ];
        $errors[0]->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('property["path_0"]');
        $errors[0]->expects($this->once())
            ->method('getInvalidValue')
            ->willReturn('val_0');
        $errors[0]->expects($this->once())
            ->method('getMessage')
            ->willReturn('message_0');

        $errors[1]->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('property["path_1"]');
        $errors[1]->expects($this->once())
            ->method('getInvalidValue')
            ->willReturn('val_1');
        $errors[1]->expects($this->once())
            ->method('getMessage')
            ->willReturn('message_1');
        $errors[1]->expects($this->exactly(2))
            ->method('getCode')
            ->willReturn('1');

        return new ConstraintViolationList($errors);
    }
}
