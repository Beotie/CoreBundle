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
namespace Beotie\CoreBundle\Tests\Request;

use Beotie\CoreBundle\Request\GenericRequestBag;
use PHPUnit\Framework\TestCase;

/**
 * Generic request bag test
 *
 * This class is used to validate the GenericRequestBag instance
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericRequestBagTest extends TestCase
{
    /**
     * Provide data
     *
     * This method provide a set of data to validate the GenericRequestBag methods
     *
     * @return [[string|number|\stdClass]]
     */
    public function provideData()
    {
        return [['data'], [12], [new \stdClass()]];
    }

    /**
     * Test construct
     *
     * This method validate the GenericRequestBag::_construct method
     *
     * @param mixed $data The data to use as method argument
     *
     * @return       void
     * @dataProvider provideData
     */
    public function testConstruct($data)
    {
        $instance = new GenericRequestBag($data);

        $reflexData = new \ReflectionProperty(GenericRequestBag::class, 'data');
        $reflexData->setAccessible(true);

        $this->assertSame($data, $reflexData->getValue($instance));
    }

    /**
     * Test getData
     *
     * This method validate the GenericRequestBag::getData method
     *
     * @param mixed $data The data to use as method argument
     *
     * @return       void
     * @dataProvider provideData
     */
    public function testGetData($data)
    {
        $reflexClass = new \ReflectionClass(GenericRequestBag::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexData = $reflexClass->getProperty('data');
        $reflexData->setAccessible(true);
        $reflexData->setValue($instance, $data);

        $this->assertSame($data, $instance->getData());
    }
}
