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
 * Request target test trait
 *
 * This trait is used to validate the HttpRequestServerAdapter instance regarding the request target logic
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait RequestTargetTestTrait
{
    /**
     * Request target provider
     *
     * Return an array of 2 dimensions of string value to be used by the testGetRequestTarget as testing data fixtures.
     *
     * @see    self::testGetRequestTarget
     * @return [[string]]
     */
    public function requestTargetProvider() : array
    {
        return [
            ['/where?q=now'],
            ['http://www.example.org/pub/WWW/TheProject.html'],
            ['www.example.com:80']
        ];
    }

    /**
     * Test getRequestTarget
     *
     * Validate that the HttpRequestServerAdapter::getRequestTarget return the result of the Request's getRequestUri()
     * method.
     *
     * @param string $requestTarget The request target expected to be returned by the
     *                              HttpRequestServerAdapter::getRequestTarget and injected into the Request instance
     *
     * @return       void
     * @dataProvider requestTargetProvider
     */
    public function testGetRequestTarget(string $requestTarget) : void
    {
        $request = $this->getRequest(
            [
                [
                    'expects' => $this->once(),
                    'method' => 'getRequestUri',
                    'willReturn' => $requestTarget
                ]
            ]
        );

        $reflex = new \ReflectionClass(HttpRequestServerAdapter::class);
        $instance = $reflex->newInstanceWithoutConstructor();

        $requestProperty = $reflex->getProperty('httpRequest');
        $requestProperty->setAccessible(true);

        $requestProperty->setValue($instance, $request);

        $this->assertEquals($requestTarget, $instance->getRequestTarget());

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
