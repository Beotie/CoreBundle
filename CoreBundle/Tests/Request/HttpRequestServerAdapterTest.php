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

use Beotie\CoreBundle\Request\HttpRequestServerAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Beotie\CoreBundle\Request\File\Factory\EmbeddedFileFactoryInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * HttpRequestServerAdapter test
 *
 * This class is used to validate the HttpRequestServerAdapter instance
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class HttpRequestServerAdapterTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the HttpRequestServerAdapter::__construct method
     *
     * @return void
     * @covers Beotie\CoreBundle\Request\HttpRequestServerAdapter::__construct
     */
    public function testConstruct() : void
    {
        $httpRequest = $this->getRequest();
        $fileFactory = $this->createMock(EmbeddedFileFactoryInterface::class);

        $instance = new HttpRequestServerAdapter($httpRequest, $fileFactory);
        $reflex = new \ReflectionClass(HttpRequestServerAdapter::class);

        $requestProperty = $reflex->getProperty('httpRequest');
        $requestProperty->setAccessible(true);

        $this->assertSame($httpRequest, $requestProperty->getValue($instance));

        $factoryProperty = $reflex->getProperty('fileFactory');
        $factoryProperty->setAccessible(true);

        $this->assertSame($fileFactory, $factoryProperty->getValue($instance));

        return;
    }

    /**
     * Test with uri
     *
     * This method validate the HttpRequestServerAdapter::withUri method
     *
     * @return void
     * @covers Beotie\CoreBundle\Request\HttpRequestServerAdapter::withUri
     */
    public function testWithUri()
    {
        $httpRequest = $this->getRequest();

        $uri = $this->createMock(UriInterface::class);
        $uri->expects($this->once())
            ->method('__toString')
            ->willReturn('/URI');

        $fileFactory = $this->createMock(EmbeddedFileFactoryInterface::class);

        $instance = new HttpRequestServerAdapter($httpRequest, $fileFactory);

        $newRequest = $instance->withUri($uri);
        $this->assertInstanceOf(HttpRequestServerAdapter::class, $newRequest);

        $requestProperty = new \ReflectionProperty(HttpRequestServerAdapter::class, 'httpRequest');
        $requestProperty->setAccessible(true);
        $innerRequest = $requestProperty->getValue($newRequest);

        $this->assertSame('/URI', $innerRequest->getPathInfo());
        $this->assertNotSame($httpRequest, $innerRequest);

        return;
    }

    /**
     * Method provider
     *
     * Return an array of 2 dimensions of string value to be used by the testGetMethod as testing data fixtures.
     *
     * @see    HttpRequestServerAdapterTest::testGetMethod
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
    private function getRequest(array $parameters = []) : MockObject
    {
        $httpRequest = $this->createMock(Request::class);
        $this->createInvocation($httpRequest, $parameters);

        $bagOptions = [
            [
                'expects' => $this->any(),
                'method' => 'all',
                'willReturn' => []
            ]
        ];
        $cookies = $this->createMock(ParameterBag::class);
        $this->createInvocation($cookies, $bagOptions);
        $httpRequest->cookies = $cookies;

        $query = $this->createMock(ParameterBag::class);
        $this->createInvocation($query, $bagOptions);
        $httpRequest->query = $query;

        $request = $this->createMock(ParameterBag::class);
        $this->createInvocation($request, $bagOptions);
        $httpRequest->request = $request;

        $file = $this->createMock(FileBag::class);
        $this->createInvocation($file, $bagOptions);
        $httpRequest->files = $file;

        $server = $this->createMock(ServerBag::class);
        $this->createInvocation($server, $bagOptions);
        $this->createInvocation($server, [['expects'=>$this->any(), 'method'=>'get']]);
        $httpRequest->server = $server;

        return $httpRequest;
    }

    /**
     * Create invokation
     *
     * Add a new Matcher instance to the given mock instance by inserting it into the inner InvocationMocker
     * instance. The inserted Matcher is created accordingly with the given parameters options.
     * The applyable options are defined by a OptionsResolver instance given by getParamResolver.
     *
     * @param MockObject $mock       The mock object to hydrate with a new Matcher instance
     * @param array      $parameters An array that configure the given MockObject's Matcher
     *
     * @see     HttpRequestServerAdapterTest::getParamResolver
     * @return  void
     * @example <pre>
     *  $this->createInvocation(
     *      $mockObject,
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
    private function createInvocation(MockObject $mock, array $parameters) : void
    {
        $resolver = $this->getParamResolver();

        foreach ($parameters as $parameter) {
            $params = $resolver->resolve($parameter);
            $invoker = $mock->expects($params['expects']);

            foreach ($params as $key => $value) {
                if ($key == 'expects') {
                    continue;
                }

                $invoker->{$key}($value);
            }
        }

        return;
    }

    /**
     * Get param resolver
     *
     * Return an OptionsResolver instance that contain 'expects', 'method', 'with', 'will' and 'willReturn' as
     * defined, and contain 'expects' as required.
     *
     * @return OptionsResolver
     */
    private function getParamResolver() : OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->setRequired('expects');
        $resolver->setDefined(
            [
                'method',
                'with',
                'will',
                'willReturn'
            ]
        );

        return $resolver;
    }
}
