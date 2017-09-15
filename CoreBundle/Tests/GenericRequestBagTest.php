<?php
declare(strict_types=1);
/**
 * This file is part of beotie/user_bundle
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
namespace Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\CoreBundle\Request\GenericRequestBag;

/**
 * Generic request bag test
 *
 * This class is used to validate the GenericRequestBag methods
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
     * Test constructor
     *
     * This method validate the GenericRequestBag::__construct method
     *
     * @param array $parameters The constructor parameter argument
     * @param array $options    The constructor option argument
     *
     * @return       void
     * @dataProvider constructorProvider
     */
    public function testConstructor(array $parameters, array $options)
    {
        $instance = new GenericRequestBag($parameters, $options);

        $paramsReflex = new \ReflectionProperty(GenericRequestBag::class, 'parameters');
        $paramsReflex->setAccessible(true);
        $this->assertEquals($parameters, $paramsReflex->getValue($instance));

        $optionsReflex = new \ReflectionProperty(GenericRequestBag::class, 'options');
        $optionsReflex->setAccessible(true);
        $this->assertEquals($options, $optionsReflex->getValue($instance));
    }

    /**
     * Test parameters
     *
     * This method validate the GenericRequestBag::getRequestParams, GenericRequestBag::hasRequestParam and
     * GenericRequestBag::getRequestParam methods
     *
     * @param array  $parameters The parameter property content
     * @param string $hasParam   A valid parameter name
     * @param string $notAParam  An invalid parameter name
     * @param mixed  $paramValue A valid parameter value
     *
     * @return       void
     * @dataProvider parameterProvider
     */
    public function testParameters(array $parameters, string $hasParam, string $notAParam, $paramValue)
    {
        $instance = new GenericRequestBag();

        $paramsReflex = new \ReflectionProperty(GenericRequestBag::class, 'parameters');
        $paramsReflex->setAccessible(true);
        $paramsReflex->setValue($instance, $parameters);

        $this->assertEquals($parameters, $instance->getRequestParams());
        $this->assertTrue($instance->hasRequestParam($hasParam));
        $this->assertFalse($instance->hasRequestParam($notAParam));

        $this->assertEquals($paramValue, $instance->getRequestParam($hasParam));
        $this->assertNull($instance->getRequestParam($notAParam));
    }

    /**
     * Test options
     *
     * This method validate the GenericRequestBag::getRequestOptions, GenericRequestBag::hasRequestOption and
     * GenericRequestBag::getRequestOption methods
     *
     * @param array  $options     The option property content
     * @param string $hasOption   A valid option name
     * @param string $notAnOption An invalid option name
     * @param mixed  $optionValue A valid option value
     *
     * @return       void
     * @dataProvider optionProvider
     */
    public function testOptions(array $options, string $hasOption, string $notAnOption, $optionValue)
    {
        $instance = new GenericRequestBag();

        $optionsReflex = new \ReflectionProperty(GenericRequestBag::class, 'options');
        $optionsReflex->setAccessible(true);
        $optionsReflex->setValue($instance, $options);

        $this->assertEquals($options, $instance->getRequestOptions());
        $this->assertTrue($instance->hasRequestOption($hasOption));
        $this->assertFalse($instance->hasRequestOption($notAnOption));

        $this->assertEquals($optionValue, $instance->getRequestOption($hasOption));
        $this->assertNull($instance->getRequestOption($notAnOption));
    }

    /**
     * Constructor provider
     *
     * This method return a set of parameters and options to validate the GenericRequestBag::__construct method
     *
     * @return [[array, array]]
     */
    public function constructorProvider()
    {
        return [
            [
                ['param' => 'paramValue'],
                ['option' => 'optionValue']
            ]
        ];
    }

    /**
     * Parameter provider
     *
     * This method return a parameter set, existing parameter name, unexisting parameter name and parameter value
     * to validate the GenericRequestBag::getRequestParams, GenericRequestBag::hasRequestParam and
     * GenericRequestBag::getRequestParam methods
     *
     * @return [[array, string, string, mixed]]
     */
    public function parameterProvider()
    {
        return [
            [
                ['param' => 'paramValue'],
                'param',
                'notParam',
                'paramValue'
            ],
            [
                ['param' => 14],
                'param',
                'notParam',
                14
            ]
        ];
    }

    /**
     * Option provider
     *
     * This method return an option set, existing option name, unexisting option name and option value
     * to validate the GenericRequestBag::getRequestOptions, GenericRequestBag::hasRequestOption and
     * GenericRequestBag::getRequestOption methods
     *
     * @return [[array, string, string, mixed]]
     */
    public function optionProvider()
    {
        return [
            [
                ['option' => 'optionValue'],
                'option',
                'notOption',
                'optionValue'
            ],
            [
                ['option' => 14],
                'option',
                'notOption',
                14
            ]
        ];
    }
}
