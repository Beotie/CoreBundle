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
namespace Beotie\CoreBundle\Tests\Request\Facade;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Beotie\CoreBundle\Response\Factory\ResponseBagFactoryInterface;
use Beotie\CoreBundle\Request\Event\Factory\RequestEventFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Beotie\CoreBundle\Request\Facade\AbstractRequestProcessor;
use Beotie\CoreBundle\Request\Event\RequestEventInterface;
use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Request\Event\RequestEvent;

/**
 * AbstractRequestProcessor test
 *
 * This class is used to validate the AbstractRequestProcessor class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class AbstractRequestProcessorTest extends TestCase
{
    /**
     * Test constructor
     *
     * This method validate the AbstractRequestProcessor::__construct method
     *
     * @return void
     */
    public function testConstructor()
    {
        $responseBagFactory = $this->createMock(ResponseBagFactoryInterface::class);
        $requestEventFactory = $this->createMock(RequestEventFactoryInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $instance = $this->getMockForAbstractClass(
            AbstractRequestProcessor::class,
            [$responseBagFactory, $requestEventFactory, $eventDispatcher]
        );

        $responseReflex = new \ReflectionProperty(AbstractRequestProcessor::class, 'responseBagFactory');
        $responseReflex->setAccessible(true);
        $this->assertSame($responseBagFactory, $responseReflex->getValue($instance));

        $requestReflex = new \ReflectionProperty(AbstractRequestProcessor::class, 'requestEventFactory');
        $requestReflex->setAccessible(true);
        $this->assertSame($requestEventFactory, $requestReflex->getValue($instance));

        $dispatcherReflex = new \ReflectionProperty(AbstractRequestProcessor::class, 'eventDispatcher');
        $dispatcherReflex->setAccessible(true);
        $this->assertSame($eventDispatcher, $dispatcherReflex->getValue($instance));
    }

    /**
     * Test getResources
     *
     * This method validate the AbstractRequestProcessor::getResources method
     *
     * @return void
     */
    public function testGetResources()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_GET_RESOURCES, 'getResources');
    }

    /**
     * Test getResource
     *
     * This method validate the AbstractRequestProcessor::getResource method
     *
     * @return void
     */
    public function testGetResource()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_GET_RESOURCE, 'getResource');
    }

    /**
     * Test postResources
     *
     * This method validate the AbstractRequestProcessor::postResources method
     *
     * @return void
     */
    public function testPostResources()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_POST_RESOURCES, 'postResources');
    }

    /**
     * Test postResource
     *
     * This method validate the AbstractRequestProcessor::postResource method
     *
     * @return void
     */
    public function testPostResource()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_POST_RESOURCE, 'postResource');
    }

    /**
     * Test putResource
     *
     * This method validate the AbstractRequestProcessor::putResource method
     *
     * @return void
     */
    public function testPutResource()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_PUT_RESOURCE, 'putResource');
    }

    /**
     * Test patchResource
     *
     * This method validate the AbstractRequestProcessor::patchResource method
     *
     * @return void
     */
    public function testPatchResource()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_PATCH_RESOURCE, 'patchResource');
    }

    /**
     * Test deleteResource
     *
     * This method validate the AbstractRequestProcessor::deleteResource method
     *
     * @return void
     */
    public function testDeleteResource()
    {
        $this->validateDispatch(AbstractRequestProcessor::EVENT_DELETE_RESOURCE, 'deleteResource');
    }

    /**
     * Test dispatch
     *
     * This method validate the dispatching of the AbstractRequestProcessor events
     *
     * @param string $eventName  The expected event name
     * @param string $methodName The method to call at top level
     *
     * @return void
     */
    private function validateDispatch(string $eventName, string $methodName)
    {
        $responseBagFactory = $this->createMock(ResponseBagFactoryInterface::class);
        $requestEventFactory = $this->createMock(RequestEventFactoryInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->equalTo($eventName),
                $this->isInstanceOf(RequestEventInterface::class)
            );

        $requestEventFactory->expects($this->once())
            ->method('getRequestEvent')
            ->willReturn($this->createMock(RequestEvent::class));

        $instance = $this->getMockForAbstractClass(
            AbstractRequestProcessor::class,
            [$responseBagFactory, $requestEventFactory, $eventDispatcher]
        );

        $dispatcherReflex = new \ReflectionProperty(AbstractRequestProcessor::class, 'eventDispatcher');
        $dispatcherReflex->setAccessible(true);
        $dispatcherReflex->setValue($instance, $eventDispatcher);

        $dispatcherReflex = new \ReflectionProperty(AbstractRequestProcessor::class, 'eventDispatcher');
        $dispatcherReflex->setAccessible(true);
        $dispatcherReflex->setValue($instance, $eventDispatcher);

        $request = $this->createMock(RequestBagInterface::class);

        $instance->{$methodName}($request);
    }
}
