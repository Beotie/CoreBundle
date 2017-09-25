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
namespace Tests\Subscriber;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEvent;
use Beotie\CoreBundle\Subscriber\GenericModelFactory;
use Beotie\CoreBundle\Model\Factory\ModelFactoryInterface;
use Beotie\CoreBundle\Subscriber\GenericModelGenerator;

/**
 * GenericModelFactory test
 *
 * This class is used to validate the GenericModelFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericModelFactoryTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the GenericModelFactory::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $modelFactory = $this->createMock(ModelFactoryInterface::class);
        $instance = new GenericModelFactory($modelFactory);

        $modelFactoryReflex = new \ReflectionProperty(GenericModelFactory::class, 'modelFactory');
        $modelFactoryReflex->setAccessible(true);

        $this->assertSame($modelFactory, $modelFactoryReflex->getValue($instance));
    }

    /**
     * Test getSubscribedEvents
     *
     * This method validate the GenericModelFactory::getSubscribedEvents method
     *
     * @return void
     */
    public function testGetSubscribedEvents()
    {
        $expected = [
            GenericModelGenerator::EVENT_ON_DTO_VALID => [
                ['createModel', 2048]
            ]
        ];

        $this->assertEquals($expected, call_user_func([GenericModelFactory::class, 'getSubscribedEvents']));
    }

    /**
     * Test validateDataTransfertObject
     *
     * This method validate the GenericModelFactory::createModel method
     *
     * @return void
     */
    public function testCreateModel()
    {
        $data = new \stdClass();
        $model = new \stdClass();

        $modelFactory = $this->createMock(ModelFactoryInterface::class);
        $modelFactory->expects($this->once())
            ->method('buildModel')
            ->with($this->identicalTo($data))
            ->willReturn($model);
        $instance = new GenericModelFactory($modelFactory);

        $event = $this->createMock(ModelGeneratorEvent::class);
        $event->expects($this->once())
            ->method('getDataTransfertObject')
            ->willReturn($data);
        $event->expects($this->once())
            ->method('setModel')
            ->with($this->identicalTo($model));

        $instance->createModel($event);
    }
}
