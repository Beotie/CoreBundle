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
use Beotie\CoreBundle\Response\Error\GenericResponseError;

/**
 * GenericResponseError test
 *
 * This class is used to validate the GenericResponseError class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorTest extends TestCase
{
    /**
     * Provide property values
     *
     * This method provide a set of property value to validate the GenericResponseError methods
     *
     * @return [[string, mixed]]
     */
    public function providePropertyValues()
    {
        return [
            ['data', 342],
            ['data', 'A_DATA'],
            ['data', new \stdClass()],
            ['dataPartLocator', 'MY_TYPE'],
            ['dataValue', 342],
            ['dataValue', 'A_DATA'],
            ['dataValue', new \stdClass()],
            ['message', 'MY_ERROR_MESSAGE'],
            ['errorCode', '0ffec5fd-33c6-410b-ba6a-9a343c350573']
        ];
    }

    /**
     * Test setters
     *
     * This method validate the GenericResponseError setters methods
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to be setted
     *
     * @return       void
     * @dataProvider providePropertyValues
     */
    public function testSetters(string $property, $value)
    {
        $instance = new GenericResponseError();

        $method = sprintf('set%s', ucfirst($property));
        $result = $instance->$method($value);
        $this->assertSame($instance, $result);

        $reflexProp = new \ReflectionProperty(GenericResponseError::class, $property);
        $reflexProp->setAccessible(true);

        $this->assertEquals($value, $reflexProp->getValue($instance));
    }

    /**
     * Test getters
     *
     * This method validate the GenericResponseError getters methods
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to be setted
     *
     * @return       void
     * @dataProvider providePropertyValues
     */
    public function testGetters(string $property, $value)
    {
        $instance = new GenericResponseError();

        $reflexProp = new \ReflectionProperty(GenericResponseError::class, $property);
        $reflexProp->setAccessible(true);
        $reflexProp->setValue($instance, $value);

        $method = sprintf('get%s', ucfirst($property));
        $this->assertEquals($value, $instance->$method());
    }
}
