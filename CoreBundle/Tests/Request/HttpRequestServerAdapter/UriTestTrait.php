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

use Psr\Http\Message\UriInterface;
use Beotie\CoreBundle\Request\File\Factory\EmbeddedFileFactoryInterface;
use Beotie\CoreBundle\Request\HttpRequestServerAdapter;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Uri test trait
 *
 * This trait is used to validate the HttpRequestServerAdapter instance regarding the uri logic
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait UriTestTrait
{
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
