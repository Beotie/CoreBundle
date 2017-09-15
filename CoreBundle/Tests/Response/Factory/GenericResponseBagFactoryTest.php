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

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\CoreBundle\Response\Factory\GenericResponseBagFactory;
use Beotie\CoreBundle\Response\GenericResponseBag;

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
        $instance = new GenericResponseBagFactory();

        $this->assertInstanceOf(GenericResponseBag::class, $instance->getResponseBag());
    }
}
