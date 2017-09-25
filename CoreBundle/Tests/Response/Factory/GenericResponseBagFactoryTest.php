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
namespace Beotie\CoreBundle\Tests\Response\Factory;

use Beotie\CoreBundle\Response\Factory\GenericResponseBagFactory;
use Beotie\CoreBundle\Response\GenericResponseBag;
use Beotie\CoreBundle\Response\Factory\ResponseErrorBagFactoryInterface;
use Beotie\CoreBundle\Response\Error\ResponseErrorBagInterface;
use Beotie\CoreBundle\Response\Factory\ResponseDataBagFactoryInterface;
use Beotie\CoreBundle\Response\Data\ResponseDataBagInterface;
use PHPUnit\Framework\TestCase;

/**
 * GenericResponseBagFactory test
 *
 * This class is used to validate the GenericResponseBagFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseBagFactoryTest extends TestCase
{
    /**
     * Test getResponseBag
     *
     * This method validate the GenericResponseBagFactory::getResponseBag method
     *
     * @return void
     */
    public function testGetResponseBag()
    {
        $errorBagFactory = $this->createMock(ResponseErrorBagFactoryInterface::class);
        $errorBagFactory->expects($this->once())
            ->method('getResponseErrorBag')
            ->willReturn($this->createMock(ResponseErrorBagInterface::class));

        $dataBagFactory = $this->createMock(ResponseDataBagFactoryInterface::class);
        $dataBagFactory->expects($this->once())
            ->method('getResponseDataBag')
            ->willReturn($this->createMock(ResponseDataBagInterface::class));

        $instance = new GenericResponseBagFactory($errorBagFactory, $dataBagFactory);

        $this->assertInstanceOf(GenericResponseBag::class, $instance->getResponseBag());
    }
}
