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

use Beotie\CoreBundle\Request\Event\RequestEvent;
use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use PHPUnit\Framework\TestCase;

/**
 * RequestEvent test
 *
 * This class is used to validate the RequestEvent class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RequestEventTest extends TestCase
{
    /**
     * Test constructor
     *
     * The method validate the RequestEvent::__construct method
     *
     * @return void
     */
    public function testConstructor()
    {
        $request = $this->createMock(RequestBagInterface::class);
        $response = $this->createMock(ResponseBagInterface::class);

        $instance = new RequestEvent($request, $response);

        $requestReflex = new \ReflectionProperty(RequestEvent::class, 'request');
        $requestReflex->setAccessible(true);

        $resposneReflex = new \ReflectionProperty(RequestEvent::class, 'response');
        $resposneReflex->setAccessible(true);

        $this->assertSame($request, $requestReflex->getValue($instance));
        $this->assertSame($response, $resposneReflex->getValue($instance));
    }

    /**
     * Test getRequest
     *
     * The method validate the RequestEvent::getRequest method
     *
     * @return void
     */
    public function testGetRequest()
    {
        $classReflex = new \ReflectionClass(RequestEvent::class);
        $instance = $classReflex->newInstanceWithoutConstructor();

        $request = $this->createMock(RequestBagInterface::class);

        $requestReflex = new \ReflectionProperty(RequestEvent::class, 'request');
        $requestReflex->setAccessible(true);
        $requestReflex->setValue($instance, $request);

        $this->assertSame($request, $instance->getRequest());
    }

    /**
     * Test getResonse
     *
     * The method validate the RequestEvent::getResonse method
     *
     * @return void
     */
    public function testGetResponse()
    {
        $classReflex = new \ReflectionClass(RequestEvent::class);
        $instance = $classReflex->newInstanceWithoutConstructor();

        $response = $this->createMock(ResponseBagInterface::class);

        $requestReflex = new \ReflectionProperty(RequestEvent::class, 'response');
        $requestReflex->setAccessible(true);
        $requestReflex->setValue($instance, $response);

        $this->assertSame($response, $instance->getResponse());
    }
}
