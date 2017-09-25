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
namespace Beotie\CoreBundle\Tests\Request\Event\Factory;

use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Request\Event\Factory\RequestEventFactory;
use Beotie\CoreBundle\Request\Event\RequestEventInterface;
use PHPUnit\Framework\TestCase;

/**
 * RequestEventFactory test
 *
 * This class is used to validate the RequestEventFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RequestEventFactoryTest extends TestCase
{
    /**
     * Test getRequestEvent
     *
     * This method validate the RequestEventFactory::getRequestEvent method
     *
     * @return void
     */
    public function testGetRequestEvent()
    {
        $request = $this->createMock(RequestBagInterface::class);
        $response = $this->createMock(ResponseBagInterface::class);

        $instance = new RequestEventFactory();
        $result = $instance->getRequestEvent($request, $response);

        $this->assertInstanceOf(RequestEventInterface::class, $result);
        $this->assertSame($request, $result->getRequest());
        $this->assertSame($response, $result->getResponse());
    }
}
