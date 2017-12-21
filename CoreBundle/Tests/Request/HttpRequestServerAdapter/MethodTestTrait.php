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
namespace Beotie\CoreBundle\Tests\Request\HttpRequestServerAdapter;

use Beotie\CoreBundle\Request\HttpRequestServerAdapter;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Method test trait
 *
 * This trait is used to validate the HttpRequestServerAdapter instance regarding the method logic
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait MethodTestTrait
{
    /**
     * Method provider
     *
     * Return an array of 2 dimensions of string value to be used by the testGetMethod as testing data fixtures.
     *
     * @see    self::testGetMethod
     * @return [[string]]
     */
    public function methodProvider() : array
    {
        return [
            ['POST'],
            ['GET'],
            ['PUT'],
            ['PATCH'],
            ['PING'],
            ['CONNECT']
        ];
    }

    /**
     * Test getMethod
     *
     * Validate that the HttpRequestServerAdapter::getMethod return the result of the Request's getMethod() method.
     *
     * @param string $method The method expected to be returned by the HttpRequestServerAdapter::getMethod and injected
     *                       into the Request instance
     *
     * @return       void
     * @dataProvider methodProvider
     */
    public function testGetMethod(string $method) : void
    {
        $request = $this->getRequest(
            [
                [
                    'expects' => $this->once(),
                    'method' => 'getMethod',
                    'willReturn' => $method
                ]
            ]
        );

        $reflex = new \ReflectionClass(HttpRequestServerAdapter::class);
        $instance = $reflex->newInstanceWithoutConstructor();

        $requestProperty = $reflex->getProperty('httpRequest');
        $requestProperty->setAccessible(true);

        $requestProperty->setValue($instance, $request);

        $this->assertEquals($method, $instance->getMethod());

        return;
    }

    /**
     * Get request
     *
     * Return an instance of Request mock that contain a ParameterBag mock in cookies, query and request properties
     * and contain a FileBag mock in file property and contain a ServerBag mock in server property.
     * For each properties, the instance will return an empty array for each call to the all() method.
     *
     * @param array $parameters An array of parameters to create invokation mocker into the returned instance
     *
     * @return  MockObject
     * @example <pre>
     *  // Simple use
     *  $this->getRequest();
     *
     *  // Usage with invokation mocker
     *  $this->getRequest(
     *      [
     *          [
     *              'expects'    => $this->any(),
     *              'method'     => 'methodName',
     *              'willReturn' => null
     *          ]
     *      ]
     *  );
     * </pre>
     */
    protected abstract function getRequest(array $parameters = []) : MockObject;
}
