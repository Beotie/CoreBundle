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
namespace Beotie\CoreBundle\Tests\Request\Builder;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Request\Builder\GenericRequestBagBuilder;
use Beotie\CoreBundle\Request\GenericRequestBag;

/**
 * GenericRequestBagBuilder test
 *
 * This class is used to validate the GenericRequestBagBuilder class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericRequestBagBuilderTest extends TestCase
{
    /**
     * Test setData
     *
     * This method validate the GenericRequestBag::setData method
     *
     * @return void
     */
    public function testSetData()
    {
        $instance = new GenericRequestBagBuilder();
        $data = new \stdClass();

        $this->assertSame($instance, $instance->setData($data));

        $reflexProperty = new \ReflectionProperty(GenericRequestBagBuilder::class, 'data');
        $reflexProperty->setAccessible(true);

        $this->assertSame($data, $reflexProperty->getValue($instance));
    }

    /**
     * Test getData
     *
     * This method validate the GenericRequestBag::getData method
     *
     * @return void
     */
    public function testGetData()
    {
        $instance = new GenericRequestBagBuilder();
        $data = new \stdClass();

        $reflexProperty = new \ReflectionProperty(GenericRequestBagBuilder::class, 'data');
        $reflexProperty->setAccessible(true);
        $reflexProperty->setValue($instance, $data);

        $this->assertSame($data, $instance->getData());
    }

    /**
     * Test getRequestBag
     *
     * This method validate the GenericRequestBag::getRequestBag method
     *
     * @return void
     */
    public function testGetRequestBag()
    {
        $instance = new GenericRequestBagBuilder();
        $this->assertEquals(new GenericRequestBag(null), $instance->getRequestBag());
    }
}
