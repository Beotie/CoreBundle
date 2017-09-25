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
namespace Beotie\CoreBundle\Tests\Response;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\Error\ResponseErrorBagInterface;
use Beotie\CoreBundle\Response\Data\ResponseDataBagInterface;
use Beotie\CoreBundle\Response\GenericResponseBag;

/**
 * GenericResponseBag test
 *
 * This class is used to validate the GenericResponseBag class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseBagTest extends TestCase
{
    /**
     * Test construct
     *
     * This method is used to validate the GenericResponseBag::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $errorBag = $this->createMock(ResponseErrorBagInterface::class);
        $dataBag = $this->createMock(ResponseDataBagInterface::class);

        $instance = new GenericResponseBag($errorBag, $dataBag);

        $reflexErrorBag = new \ReflectionProperty(GenericResponseBag::class, 'errorBag');
        $reflexErrorBag->setAccessible(true);
        $this->assertSame($errorBag, $reflexErrorBag->getValue($instance));

        $reflexDataBag = new \ReflectionProperty(GenericResponseBag::class, 'dataBag');
        $reflexDataBag->setAccessible(true);
        $this->assertSame($dataBag, $reflexDataBag->getValue($instance));
    }

    /**
     * Test getErrorBag
     *
     * This method is used to validate the GenericResponseBag::getErrorBag method
     *
     * @return void
     */
    public function testGetErrorBag()
    {
        $reflexClass = new \ReflectionClass(GenericResponseBag::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexErrorBag = $reflexClass->getProperty('errorBag');
        $reflexErrorBag->setAccessible(true);

        $errorBag = $this->createMock(ResponseErrorBagInterface::class);
        $reflexErrorBag->setValue($instance, $errorBag);

        $this->assertSame($errorBag, $instance->getErrorBag());
    }

    /**
     * Test getDataBag
     *
     * This method is used to validate the GenericResponseBag::getDataBag method
     *
     * @return void
     */
    public function testGetDataBag()
    {
        $reflexClass = new \ReflectionClass(GenericResponseBag::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexDataBag = $reflexClass->getProperty('dataBag');
        $reflexDataBag->setAccessible(true);

        $dataBag = $this->createMock(ResponseDataBagInterface::class);
        $reflexDataBag->setValue($instance, $dataBag);

        $this->assertSame($dataBag, $instance->getDataBag());
    }
}
