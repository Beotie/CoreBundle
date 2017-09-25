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
use Beotie\CoreBundle\Subscriber\GenericModelPersister;
use Beotie\CoreBundle\Subscriber\GenericModelGenerator;
use Doctrine\Common\Persistence\ObjectManager;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEventInterface;

/**
 * GenericModelPersister test
 *
 * This class is used to validate the GenericModelPersister class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericModelPersisterTest extends TestCase
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
        $modelManager = $this->createMock(ObjectManager::class);
        $instance = new GenericModelPersister($modelManager);

        $modelManagerReflex = new \ReflectionProperty(GenericModelPersister::class, 'modelManager');
        $modelManagerReflex->setAccessible(true);

        $this->assertSame($modelManager, $modelManagerReflex->getValue($instance));
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
                ['persistModel', 1024],
                ['storeModel', 512]
            ]
        ];

        $this->assertEquals($expected, call_user_func([GenericModelPersister::class, 'getSubscribedEvents']));
    }

    /**
     * Test persistModel
     *
     * This method validate the GenericModelPersister::persistModel method
     *
     * @return void
     */
    public function testPersistModel()
    {
        $data = new \stdClass();

        $event = $this->createMock(ModelGeneratorEventInterface::class);
        $event->expects($this->once())
            ->method('getModel')
            ->willReturn($data);

        $modelManager = $this->createMock(ObjectManager::class);
        $modelManager->expects($this->once())
            ->method('persist')
            ->with($this->identicalTo($data));

        $instance = new GenericModelPersister($modelManager);

        $this->assertSame($event, $instance->persistModel($event));
    }

    /**
     * Test storeModel
     *
     * This method validate the GenericModelPersister::storeModel method
     *
     * @return void
     */
    public function testStoreModel()
    {
        $event = $this->createMock(ModelGeneratorEventInterface::class);

        $modelManager = $this->createMock(ObjectManager::class);
        $modelManager->expects($this->once())
            ->method('flush');

        $instance = new GenericModelPersister($modelManager);

        $this->assertSame($event, $instance->storeModel($event));
    }
}
