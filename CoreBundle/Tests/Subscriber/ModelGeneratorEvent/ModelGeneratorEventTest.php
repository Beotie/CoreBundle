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
namespace Beotie\CoreBundle\Tests\Subscriber\ModelGeneratorEvent;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Subscriber\ModelGeneratorEvent\ModelGeneratorEvent;

/**
 * ModelGeneratorEvent test
 *
 * This class is used to validate the ModelGeneratorEvent class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ModelGeneratorEventTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the ModelGeneratorEvent::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $dto = new \stdClass();
        $response = $this->createMock(ResponseBagInterface::class);

        $instance = new ModelGeneratorEvent($dto, $response);

        $reflexDto = new \ReflectionProperty(ModelGeneratorEvent::class, 'dataTransfertObject');
        $reflexDto->setAccessible(true);

        $reflexResponse = new \ReflectionProperty(ModelGeneratorEvent::class, 'response');
        $reflexResponse->setAccessible(true);

        $this->assertSame($dto, $reflexDto->getValue($instance));
        $this->assertSame($response, $reflexResponse->getValue($instance));
    }

    /**
     * Test getDataTransfertObject
     *
     * This method validate the ModelGeneratorEvent::getDataTransfertObject method
     *
     * @return void
     */
    public function testGetDataTransfertObject()
    {
        $dto = new \stdClass();
        $reflexClass = new \ReflectionClass(ModelGeneratorEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexDto = $reflexClass->getProperty('dataTransfertObject');
        $reflexDto->setAccessible(true);
        $reflexDto->setValue($instance, $dto);

        $this->assertSame($dto, $instance->getDataTransfertObject());
    }

    /**
     * Test setDataTransfertObject
     *
     * This method validate the ModelGeneratorEvent::setDataTransfertObject method
     *
     * @return void
     */
    public function testSetDataTransfertObject()
    {
        $dto = new \stdClass();
        $reflexClass = new \ReflectionClass(ModelGeneratorEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $this->assertSame($instance, $instance->setDataTransfertObject($dto));

        $reflexDto = $reflexClass->getProperty('dataTransfertObject');
        $reflexDto->setAccessible(true);

        $this->assertSame($dto, $reflexDto->getValue($instance));
    }

    /**
     * Test getResponse
     *
     * This method validate the ModelGeneratorEvent::getResponse method
     *
     * @return void
     */
    public function testGetResponse()
    {
        $response = $this->createMock(ResponseBagInterface::class);
        $reflexClass = new \ReflectionClass(ModelGeneratorEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexResponse = $reflexClass->getProperty('response');
        $reflexResponse->setAccessible(true);
        $reflexResponse->setValue($instance, $response);

        $this->assertSame($response, $instance->getResponse());
    }

    /**
     * Test setModel
     *
     * This method validate the ModelGeneratorEvent::setModel method
     *
     * @return void
     */
    public function testSetModel()
    {
        $model = new \stdClass();
        $reflexClass = new \ReflectionClass(ModelGeneratorEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $this->assertSame($instance, $instance->setModel($model));

        $reflexModel = $reflexClass->getProperty('model');
        $reflexModel->setAccessible(true);

        $this->assertSame($model, $reflexModel->getValue($instance));
    }

    /**
     * Test getModel
     *
     * This method validate the ModelGeneratorEvent::getModel method
     *
     * @return void
     */
    public function testGetModel()
    {
        $model = new \stdClass();
        $reflexClass = new \ReflectionClass(ModelGeneratorEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexModel = $reflexClass->getProperty('model');
        $reflexModel->setAccessible(true);
        $reflexModel->setValue($instance, $model);

        $this->assertSame($model, $instance->getModel());
    }
}
