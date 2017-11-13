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
namespace Beotie\CoreBundle\Tests\Request\Event;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Request\Event\RequestBagGenerationEvent;
use Psr\Http\Message\ServerRequestInterface;
use Beotie\CoreBundle\Request\Builder\RequestBagBuilderInterface;

/**
 * RequestBagGenerationEvent test
 *
 * This class is used to validate the RequestBagGenerationEvent class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RequestBagGenerationEventTest extends TestCase
{
    /**
     * Test construct
     *
     * This method validate the GenericRequestBag::__construct method
     *
     * @return void
     */
    public function testConstruct() : void
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $requestBuilder = $this->createMock(RequestBagBuilderInterface::class);

        $instance = new RequestBagGenerationEvent($serverRequest, $requestBuilder);

        $reflexClass = new \ReflectionClass(RequestBagGenerationEvent::class);
        $reflexServerRequest = $reflexClass->getProperty('serverRequest');
        $reflexServerRequest->setAccessible(true);

        $this->assertSame($serverRequest, $reflexServerRequest->getValue($instance));

        $reflexRequestBag = $reflexClass->getProperty('requestBagBuilder');
        $reflexRequestBag->setAccessible(true);
        $this->assertSame($requestBuilder, $reflexRequestBag->getValue($instance));

        return;
    }

    /**
     * Test getServerRequest
     *
     * This method validate the GenericRequestBag::getServerRequest method
     *
     * @return void
     */
    public function testGetServerRequest() : void
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);

        $reflexClass = new \ReflectionClass(RequestBagGenerationEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexServerRequest = $reflexClass->getProperty('serverRequest');
        $reflexServerRequest->setAccessible(true);
        $reflexServerRequest->setValue($instance, $serverRequest);

        $this->assertSame($serverRequest, $instance->getServerRequest());

        return;
    }

    /**
     * Test getRequestBagBuilder
     *
     * This method validate the GenericRequestBag::getRequestBagBuilder method
     *
     * @return void
     */
    public function testGetRequestBagBuilder() : void
    {
        $requestBuilder = $this->createMock(RequestBagBuilderInterface::class);

        $reflexClass = new \ReflectionClass(RequestBagGenerationEvent::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        $reflexRequestBuilder = $reflexClass->getProperty('requestBagBuilder');
        $reflexRequestBuilder->setAccessible(true);
        $reflexRequestBuilder->setValue($instance, $requestBuilder);

        $this->assertSame($requestBuilder, $instance->getRequestBagBuilder());

        return;
    }
}
