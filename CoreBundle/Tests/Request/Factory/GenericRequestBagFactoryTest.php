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
namespace Beotie\CoreBundle\Tests\Request\Factory;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Request\Factory\GenericRequestBagFactory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Beotie\CoreBundle\Request\Builder\GenericRequestBagBuilder;
use Beotie\CoreBundle\Request\Event\RequestBagGenerationEvent;
use Beotie\CoreBundle\Request\GenericRequestBag;

/**
 * GenericRequestBagFactory test
 *
 * This class is used to validate the GenericRequestBagFactory class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericRequestBagFactoryTest extends TestCase
{
    /**
     * Test constructor
     *
     * This method validate the GenericRequestBagFactory::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $dispatcher = $this->createMock(EventDispatcherInterface::class);

        $instance = new GenericRequestBagFactory($serverRequest, $dispatcher);

        $reflexServerRequest = new \ReflectionProperty(GenericRequestBagFactory::class, 'serverRequest');
        $reflexServerRequest->setAccessible(true);
        $this->assertSame($serverRequest, $reflexServerRequest->getValue($instance));

        $reflexDispatcher = new \ReflectionProperty(GenericRequestBagFactory::class, 'eventDispatcher');
        $reflexDispatcher->setAccessible(true);
        $this->assertSame($dispatcher, $reflexDispatcher->getValue($instance));
    }

    /**
     * Test getRequestBag
     *
     * This method validate the GenericRequestBagFactory::getRequestBag method
     *
     * @return                                      void
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function testGetRequestBag()
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->equalTo(GenericRequestBagFactory::EVENT_REQUEST_GENERATION),
                $this->isInstanceOf(RequestBagGenerationEvent::class)
            );

        $reflexClass = new \ReflectionClass(GenericRequestBagFactory::class);
        $instance = $reflexClass->newInstanceWithoutConstructor();

        foreach (['serverRequest', 'eventDispatcher'] as $property) {
            $reflexProperty = new \ReflectionProperty(GenericRequestBagFactory::class, $property);
            $reflexProperty->setAccessible(true);
            $reflexProperty->setValue($instance, $$property);
        }

        $this->assertInstanceOf(GenericRequestBag::class, $instance->getRequestBag());
    }
}
