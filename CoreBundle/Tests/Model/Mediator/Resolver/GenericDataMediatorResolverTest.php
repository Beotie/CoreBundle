<?php
declare(strict_types=1);
/**
 * This file is part of beotie/user_bundle
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
namespace Beotie\CoreBundle\Tests\Model\Mediator\Resolver;

use Beotie\CoreBundle\Model\Mediator\Resolver\GenericDataMediatorResolver;
use Beotie\CoreBundle\Model\Mediator\ExternalDataMediatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Generic data mediator resolver test
 *
 * This class is used to validate the GenericDataMediatorResolver instance
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDataMediatorResolverTest extends TestCase
{
    /**
     * Test addMediator
     *
     * This method validate the GenericDataMediatorResolver::addMediator method
     *
     * @return void
     */
    public function testAddMediator()
    {
        $instance = new GenericDataMediatorResolver();

        $mediators = [
            $this->createMock(ExternalDataMediatorInterface::class),
            $this->createMock(ExternalDataMediatorInterface::class),
            $this->createMock(ExternalDataMediatorInterface::class)
        ];

        foreach ($mediators as $mediator) {
            $result = $instance->addMediator($mediator);

            $this->assertSame($instance, $result);
            $this->assertTrue($instance->contains($mediator));
        }
    }

    /**
     * Test hasMediator
     *
     * This method validate the GenericDataMediatorResolver::hasMediator method
     *
     * @return void
     */
    public function testHasMediator()
    {
        $data = new \stdClass();

        $unsupportMediator = $this->createMock(ExternalDataMediatorInterface::class);
        $unsupportMediator->expects($this->exactly(2))
            ->method('support')
            ->with($this->identicalTo($data))
            ->willReturn(false);

        $instance = new GenericDataMediatorResolver();
        $instance->attach($unsupportMediator);

        $this->assertFalse($instance->hasMediator($data));

        $supportMediator = $this->createMock(ExternalDataMediatorInterface::class);
        $supportMediator->expects($this->once())
            ->method('support')
            ->with($this->identicalTo($data))
            ->willReturn(true);
        $instance->attach($supportMediator);

        $this->assertTrue($instance->hasMediator($data));
    }

    /**
     * Test getMediator
     *
     * This method validate the GenericDataMediatorResolver::getMediator method
     *
     * @return void
     */
    public function testGetMediator()
    {
        $data = new \stdClass();

        $unsupportMediator = $this->createMock(ExternalDataMediatorInterface::class);
        $unsupportMediator->expects($this->once())
            ->method('support')
            ->with($this->identicalTo($data))
            ->willReturn(false);

        $supportMediator = $this->createMock(ExternalDataMediatorInterface::class);
        $supportMediator->expects($this->once())
            ->method('support')
            ->with($this->identicalTo($data))
            ->willReturn(true);

        $instance = new GenericDataMediatorResolver();
        $instance->attach($unsupportMediator);
        $instance->attach($supportMediator);

        $this->assertSame($supportMediator, $instance->getMediator($data));
    }

    /**
     * Test getMediator with error
     *
     * This method validate the GenericDataMediatorResolver::getMediator method with unsupported data
     *
     * @return void
     */
    public function testGetMediatorError()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No mediator found for given data');

        $data = new \stdClass();

        $unsupportMediator = $this->createMock(ExternalDataMediatorInterface::class);
        $unsupportMediator->expects($this->once())
            ->method('support')
            ->with($this->identicalTo($data))
            ->willReturn(false);

        $instance = new GenericDataMediatorResolver();
        $instance->attach($unsupportMediator);

        $instance->getMediator($data);
    }
}
