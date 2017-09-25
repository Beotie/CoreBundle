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
use Beotie\CoreBundle\Response\Data\GenericResponseData;

/**
 * GenericResponseData test
 *
 * This class is used to validate the GenericResponseData class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseDataTest extends TestCase
{
    /**
     * Provide property values
     *
     * This method provide a set of property value to validate the GenericResponseData methods
     *
     * @return [[string, mixed]]
     */
    public function providePropertyValues()
    {
        return [
            ['data', 342],
            ['data', 'A_DATA'],
            ['data', new \stdClass()],
            ['type', 'MY_TYPE'],
            ['id', 124],
            ['id', '0ffec5fd-33c6-410b-ba6a-9a343c350573'],
            ['attributes', ['attr1' => 'val1']],
            ['relationships', ['rel1' => 'val1']],
            ['links', ['link1' => 'val1']]
        ];
    }

    /**
     * Test setters
     *
     * This method validate the GenericResponseData setters methods
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to be setted
     *
     * @return       void
     * @dataProvider providePropertyValues
     */
    public function testSetters(string $property, $value)
    {
        $instance = new GenericResponseData();

        $method = sprintf('set%s', ucfirst($property));
        $result = $instance->$method($value);
        $this->assertSame($instance, $result);

        $reflexProp = new \ReflectionProperty(GenericResponseData::class, $property);
        $reflexProp->setAccessible(true);

        $this->assertEquals($value, $reflexProp->getValue($instance));
    }

    /**
     * Test getters
     *
     * This method validate the GenericResponseData getters methods
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to be setted
     *
     * @return       void
     * @dataProvider providePropertyValues
     */
    public function testGetters(string $property, $value)
    {
        $instance = new GenericResponseData();

        $reflexProp = new \ReflectionProperty(GenericResponseData::class, $property);
        $reflexProp->setAccessible(true);
        $reflexProp->setValue($instance, $value);

        $method = sprintf('get%s', ucfirst($property));
        $this->assertEquals($value, $instance->$method());
    }
}
