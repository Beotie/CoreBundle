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

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Response\Factory\GenericResponseDataBagFactory;
use Beotie\CoreBundle\Response\Data\GenericResponseDataBag;

/**
 * GenericResponseDataBagFactory test
 *
 * This class is used to validate the GenericResponseDataBagFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataBagFactoryTest extends TestCase
{
    /**
     * Test getResponseDataBag
     *
     * This method validate the GenericResponseDataBagFactory::getResponseDataBag method
     *
     * @return void
     */
    public function testGetResponseDataBag()
    {
        $instance = new GenericResponseDataBagFactory();
        $this->assertInstanceOf(GenericResponseDataBag::class, $instance->getResponseDataBag());
    }
}
