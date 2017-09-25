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
namespace Beotie\CoreBundle\Tests\Response\Data;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\Data\ResponseDataInterface;
use Beotie\CoreBundle\Response\Data\GenericResponseDataBag;

/**
 * GenericResponseDataBag test
 *
 * This class is used to validate the GenericResponseDataBag class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataBagTest extends TestCase
{
    /**
     * Test addDataPart
     *
     * This method validate the GenericResponseDataBag::addDataPart method
     *
     * @return void
     */
    public function testAddDataPart()
    {
        $dataPart = $this->createMock(ResponseDataInterface::class);
        $instance = new GenericResponseDataBag();

        $result = $instance->addDataPart($dataPart);
        $this->assertSame($instance, $result);
        $this->assertContains($dataPart, iterator_to_array($instance));
    }

    /**
     * Test countDataParts
     *
     * This method validate the GenericResponseDataBag::countDataParts method
     *
     * @return void
     */
    public function testCountDataParts()
    {
        $dataParts = [
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class)
        ];
        $instance = new GenericResponseDataBag();

        foreach ($dataParts as $index => $dataPart) {
            $instance->add($index, $dataPart);
        }

        $this->assertEquals(count($dataParts), $instance->countDataParts());
    }

    /**
     * Test getDataPart
     *
     * This method validate the GenericResponseDataBag::getDataPart method
     *
     * @return void
     */
    public function testGetDataPart()
    {
        $dataParts = [
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class)
        ];
        $instance = new GenericResponseDataBag();

        foreach ($dataParts as $dataPart) {
            $instance->push($dataPart);
        }
        $this->assertNull($instance->getDataPart(count($dataParts)));

        foreach ($dataParts as $index => $dataPart) {
            $this->assertSame($dataPart, $instance->getDataPart($index));
        }
    }

    /**
     * Test setDataPart
     *
     * This method validate the GenericResponseDataBag::setDataPart method
     *
     * @return void
     */
    public function testSetDataPart()
    {
        $dataParts = [
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class)
        ];
        $instance = new GenericResponseDataBag();

        foreach ($dataParts as $dataPart) {
            $instance->push($dataPart);
        }

        $dataPart = $this->createMock(ResponseDataInterface::class);
        $this->assertSame($instance, $instance->setDataPart(1, $dataPart));
        $this->assertSame($dataPart, $instance->offsetGet(1));
    }

    /**
     * Test getDataParts
     *
     * This method validate the GenericResponseDataBag::getDataParts method
     *
     * @return GenericResponseDataBag
     */
    public function testGetDataParts()
    {
        $dataParts = [
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class)
        ];
        $instance = new GenericResponseDataBag();

        foreach ($dataParts as $dataPart) {
            $instance->push($dataPart);
        }

        $this->assertSame($dataParts, $instance->getDataParts());

        return $instance;
    }

    /**
     * Test setDataParts
     *
     * This method validate the GenericResponseDataBag::setDataParts method
     *
     * @param GenericResponseDataBag $instance The instance to validate
     *
     * @return  void
     * @depends testGetDataParts
     */
    public function testSetDataParts(GenericResponseDataBag $instance)
    {
        $newDataParts = [
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class)
        ];
        $instance->setDataParts($newDataParts);

        $this->assertSame($newDataParts, $instance->getDataParts());
    }

    /**
     * Test flushDataParts
     *
     * This method validate the GenericResponseDataBag::flushDataParts method
     *
     * @return void
     */
    public function testFlushDataParts()
    {
        $dataParts = [
            $this->createMock(ResponseDataInterface::class),
            $this->createMock(ResponseDataInterface::class)
        ];
        $instance = new GenericResponseDataBag();

        foreach ($dataParts as $dataPart) {
            $instance->push($dataPart);
        }

        $this->assertSame($dataParts, $instance->flushDataParts());
        $this->assertTrue($instance->isEmpty());
    }
}
