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
use Beotie\CoreBundle\Response\Factory\GenericResponseErrorFactory;
use Beotie\CoreBundle\Response\Error\GenericResponseError;

/**
 * GenericResponseErrorFactory test
 *
 * This class is used to validate the GenericResponseErrorFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorFactoryTest extends TestCase
{
    /**
     * Test getResponseError
     *
     * This method validate the GenericResponseErrorFactory::getResponseError method
     *
     * @return void
     */
    public function testGetResponseError()
    {
        $instance = new GenericResponseErrorFactory();
        $this->assertInstanceOf(GenericResponseError::class, $instance->getResponseError());
    }
}
