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
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PHPUnit\Framework\MockObject\MockObject;
use Beotie\CoreBundle\Tests\Request\HttpRequestServerAdapter as TestTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

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
    use TestTrait\UriTestTrait,
        TestTrait\MethodTestTrait,
        TestTrait\RequestTargetTestTrait,
        TestTrait\QueryTestTrait;

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
     * Test getServerParams
     *
     * Validate the HttpRequestServerAdapter::getServerParams by injecting mocked Request object. The injected request
     * is expected to return an array of server parameters and this method validate the return value.
     *
     * @return void
     */
    public function testGetServerParams() : void
    {
        $serverParam = ['server' => 'param'];

        $request = $this->getRequest([], ['server' => ['all' => $serverParam]]);

        $reflex = new \ReflectionClass(HttpRequestServerAdapter::class);
        $instance = $reflex->newInstanceWithoutConstructor();

        $requestProperty = $reflex->getProperty('httpRequest');
        $requestProperty->setAccessible(true);
        $requestProperty->setValue($instance, $request);

        $this->assertEquals($serverParam, $instance->getServerParams());

        return;
    }

    /**
     * Get request
     *
     * Return an instance of Request mock that contain a ParameterBag mock in cookies, query and request properties
     * and contain a FileBag mock in file property and contain a ServerBag mock in server property.
     * For each properties, the instance will be configured with the according key given bag options. If the
     * configuration is not specified, the instance will return an empty array for each call of all() method.
     *
     * @param array $parameters An array of parameters to create invokation mocker into the returned instance
     * @param array $bagOptions An array containing the bag invocation configuration
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
     *
     *  // Usage with bag invokation configuration
     *  $this->getRequest(
     *      [],
     *      [
     *          'server' => ['all' => []],
     *          'query' => ['any all' => []],
     *          'request' => [
     *              [
     *                  'expects'    => $this->any(),
     *                  'method'     => 'all',
     *                  'willReturn' => []
     *              ]
     *          ]
     *      ]
     *  );
     * </pre>
     */
    protected function getRequest(array $parameters = [], array $bagOptions = []) : MockObject
    {
        $httpRequest = $this->createMock(Request::class);
        $this->createInvocation($httpRequest, $parameters);

        $fallbackBagOptions = ['all' => []];
        $cookies = $this->createMock(ParameterBag::class);
        $this->createInvocation($cookies, ($bagOptions['cookies'] ?? $fallbackBagOptions));
        $httpRequest->cookies = $cookies;

        $query = $this->createMock(ParameterBag::class);
        $this->createInvocation($query, ($bagOptions['query'] ?? $fallbackBagOptions));
        $httpRequest->query = $query;

        $request = $this->createMock(ParameterBag::class);
        $this->createInvocation($request, ($bagOptions['request'] ?? $fallbackBagOptions));
        $httpRequest->request = $request;

        $file = $this->createMock(FileBag::class);
        $this->createInvocation($file, ($bagOptions['files'] ?? $fallbackBagOptions));
        $httpRequest->files = $file;

        $server = $this->createMock(ServerBag::class);
        $this->createInvocation($server, ($bagOptions['server'] ?? $fallbackBagOptions));
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
     * A short notation is abble to be used to avoid using full explained option array by using associative
     * array. In this case, the given key define the method name to be called and the value become the return
     * value of the function. By using the gessInvocationTarget, it is possible to use space separated invocation
     * time and method name as key.
     *
     * @param MockObject $mock       The mock object to hydrate with a new Matcher instance
     * @param array      $parameters An array that configure the given MockObject's Matcher
     *
     * @see     HttpRequestServerAdapterTest::getParamResolver
     * @return  void
     * @example <pre>
     *  // Full defined option
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
     *
     *  // Same thing with shortcut notation
     *  $this->createInvocation(
     *      $mockObject,
     *      [
     *              'methodName' => null
     *      ]
     *  );
     *
     *  // Or with once invocation time
     *  $this->createInvocation(
     *      $mockObject,
     *      [
     *              'once methodName' => null
     *      ]
     *  );
     * </pre>
     */
    private function createInvocation(MockObject $mock, array $parameters) : void
    {
        $resolver = $this->getParamResolver();

        foreach ($parameters as $parameterName => $parameter) {
            try {
                if (!is_array($parameter)) {
                    throw new InvalidArgumentException('Time to call callback');
                }

                $params = $resolver->resolve($parameter);
            } catch (InvalidArgumentException $exception) {
                unset($exception);
                list($invocationCount, $methodName) = $this->guessInvocationTarget($parameterName);

                $fallbackParameters = [
                    [
                        'expects' => $invocationCount,
                        'method' => $methodName,
                        'willReturn' => $parameter
                    ]
                ];

                $this->createInvocation($mock, $fallbackParameters);
                return;
            }

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
     * Guess invocation target
     *
     * Return an array corresponding to the parsing of the given fullTarget, representing the space separated expected
     * method invocation time and method invocation name.
     *
     * @param string $fullTarget The space separated representation of the method invocation time and method
     *                           invocation name
     *
     * @return  array
     * @example <pre>
     *  $this->gessInvocationTarget('any methodName'); // Will return [$this->any(), 'methodName']
     * </pre>
     */
    private function guessInvocationTarget(string $fullTarget) : array
    {
        $tokens = explode(' ', $fullTarget);

        if (count($tokens) === 1) {
            return [
                $this->any(),
                $tokens[0]
            ];
        }

        return [
            $this->{$tokens[0]}(),
            $tokens[1]
        ];
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

    /**
     * Get test case
     *
     * Return an instance of TestCase
     *
     * @return TestCase
     */
    protected function getTestCase() : TestCase
    {
        return $this;
    }
}
