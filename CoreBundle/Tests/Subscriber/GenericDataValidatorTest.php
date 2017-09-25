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
use Beotie\CoreBundle\Subscriber\GenericDataValidator;
use Beotie\CoreBundle\Model\Factory\ModelFactoryInterface;
use Beotie\CoreBundle\Subscriber\GenericModelGenerator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Beotie\CoreBundle\Event\EventInterface;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEvent;

/**
 * GenericDataValidator test
 *
 * This class is used to validate the GenericDataValidator class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDataValidatorTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the GenericDataValidator::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $modelFactory = $this->createMock(ModelFactoryInterface::class);
        $instance = new GenericDataValidator($modelFactory);

        $modelFactoryReflex = new \ReflectionProperty(GenericDataValidator::class, 'modelFactory');
        $modelFactoryReflex->setAccessible(true);

        $this->assertSame($modelFactory, $modelFactoryReflex->getValue($instance));
    }

    /**
     * Test getSubscribedEvents
     *
     * This method validate the GenericDataValidator::getSubscribedEvents method
     *
     * @return void
     */
    public function testGetSubscribedEvents()
    {
        $expected = [
            GenericModelGenerator::EVENT_GENERATE_MODEL => [
                ['validateDataTransfertObject', 0]
            ]
        ];

        $this->assertEquals($expected, call_user_func([GenericDataValidator::class, 'getSubscribedEvents']));
    }

    /**
     * Get validation state
     *
     * This method provide a set of validation state and event name to validate the
     * GenericDataValidator::validateDataTransfertObject method
     *
     * @return [[boolean|string]]
     */
    public function getValidationState()
    {
        return [
            [true, GenericModelGenerator::EVENT_ON_DTO_VALID],
            [false, GenericModelGenerator::EVENT_ON_DTO_INVALID]
        ];
    }

    /**
     * Test validateDataTransfertObject
     *
     * This method validate the GenericDataValidator::validateDataTransfertObject method
     *
     * @param bool   $validationState The validation state result
     * @param string $eventName       The expected event dispatched name
     *
     * @return       void
     * @dataProvider getValidationState
     */
    public function testValidateDataTransfertObject(bool $validationState, string $eventName)
    {
        $data = new \stdClass();

        $modelFactory = $this->createMock(ModelFactoryInterface::class);
        $modelFactory->expects($this->once())
            ->method('isValid')
            ->with($this->identicalTo($data))
            ->willReturn($validationState);
        $instance = new GenericDataValidator($modelFactory);

        $event = $this->createMock(ModelGeneratorEvent::class);
        $event->expects($this->once())
            ->method('getDataTransfertObject')
            ->willReturn($data);

        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo($eventName), $this->identicalTo($event))
            ->willReturn($this->createMock(EventInterface::class));

        $instance->validateDataTransfertObject($event, '', $dispatcher);
    }
}
