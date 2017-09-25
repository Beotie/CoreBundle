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
use Beotie\CoreBundle\Response\Factory\GenericResponseErrorBagFactory;
use Beotie\CoreBundle\Response\Error\GenericResponseErrorBag;

/**
 * GenericResponseErrorBagFactory test
 *
 * This class is used to validate the GenericResponseErrorBagFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorBagFactoryTest extends TestCase
{
    /**
     * Test getResponseErrorBag
     *
     * This method validate the GenericResponseErrorBagFactory::getResponseErrorBag method
     *
     * @return void
     */
    public function testGetResponseErrorBag()
    {
        $instance = new GenericResponseErrorBagFactory();
        $this->assertInstanceOf(GenericResponseErrorBag::class, $instance->getResponseErrorBag());
    }
}
