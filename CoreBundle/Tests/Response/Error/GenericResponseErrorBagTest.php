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
namespace Beotie\CoreBundle\Tests\Response\Error;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\Error\ResponseErrorInterface;
use Beotie\CoreBundle\Response\Error\GenericResponseErrorBag;

/**
 * GenericResponseErrorBag test
 *
 * This class is used to validate the GenericResponseErrorBag class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorBagTest extends TestCase
{
    /**
     * Test addErrorPart
     *
     * This method validate the GenericResponseErrorBag::addErrorPart method
     *
     * @return void
     */
    public function testAddErrorPart()
    {
        $errorPart = $this->createMock(ResponseErrorInterface::class);
        $instance = new GenericResponseErrorBag();

        $result = $instance->addErrorPart($errorPart);
        $this->assertSame($instance, $result);
        $this->assertContains($errorPart, iterator_to_array($instance));
    }

    /**
     * Test countErrorParts
     *
     * This method validate the GenericResponseErrorBag::countErrorParts method
     *
     * @return void
     */
    public function testCountErrorParts()
    {
        $errorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $instance = new GenericResponseErrorBag();

        foreach ($errorParts as $index => $errorPart) {
            $instance->add($index, $errorPart);
        }

        $this->assertEquals(count($errorParts), $instance->countErrorParts());
    }

    /**
     * Test getErrorPart
     *
     * This method validate the GenericResponseErrorBag::getErrorPart method
     *
     * @return void
     */
    public function testGetErrorPart()
    {
        $errorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $instance = new GenericResponseErrorBag();

        foreach ($errorParts as $errorPart) {
            $instance->push($errorPart);
        }
        $this->assertNull($instance->getErrorPart(count($errorParts)));

        foreach ($errorParts as $index => $errorPart) {
            $this->assertSame($errorPart, $instance->getErrorPart($index));
        }
    }

    /**
     * Test setErrorPart
     *
     * This method validate the GenericResponseErrorBag::setErrorPart method
     *
     * @return void
     */
    public function testSetErrorPart()
    {
        $errorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $instance = new GenericResponseErrorBag();

        foreach ($errorParts as $errorPart) {
            $instance->push($errorPart);
        }

        $errorPart = $this->createMock(ResponseErrorInterface::class);
        $this->assertSame($instance, $instance->setErrorPart(1, $errorPart));
        $this->assertSame($errorPart, $instance->offsetGet(1));
    }

    /**
     * Test getErrorParts
     *
     * This method validate the GenericResponseErrorBag::getErrorParts method
     *
     * @return GenericResponseErrorBag
     */
    public function testGetErrorParts()
    {
        $errorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $instance = new GenericResponseErrorBag();

        foreach ($errorParts as $errorPart) {
            $instance->push($errorPart);
        }

        $this->assertSame($errorParts, $instance->getErrorParts());

        return $instance;
    }

    /**
     * Test setErrorParts
     *
     * This method validate the GenericResponseErrorBag::setErrorParts method
     *
     * @param GenericResponseErrorBag $instance The instance to validate
     *
     * @return  void
     * @depends testGetErrorParts
     */
    public function testSetErrorParts(GenericResponseErrorBag $instance)
    {
        $newErrorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $instance->setErrorParts($newErrorParts);

        $this->assertSame($newErrorParts, $instance->getErrorParts());
    }

    /**
     * Test flushErrorParts
     *
     * This method validate the GenericResponseErrorBag::flushErrorParts method
     *
     * @return void
     */
    public function testFlushErrorParts()
    {
        $errorParts = [
            $this->createMock(ResponseErrorInterface::class),
            $this->createMock(ResponseErrorInterface::class)
        ];
        $instance = new GenericResponseErrorBag();

        foreach ($errorParts as $errorPart) {
            $instance->push($errorPart);
        }

        $this->assertSame($errorParts, $instance->flushErrorParts());
        $this->assertTrue($instance->isEmpty());
    }
}
