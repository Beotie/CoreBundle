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
namespace Beotie\CoreBundle\Tests\DependencyInjection;

use Beotie\CoreBundle\DependencyInjection\BeotieCoreExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * BeotieCoreExtension test
 *
 * This class is used to validate the BeotieCoreExtension
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class BeotieCoreExtensionTest extends TestCase
{
    /**
     * Test load
     *
     * This method validate the BeotieCoreExtension::load method
     *
     * @return void
     */
    public function testLoad()
    {
        $instance = new BeotieCoreExtension();

        $container = $this->createMock(ContainerBuilder::class);

        $container->expects($this->once())
            ->method('fileExists')
            ->with($this->stringEndsWith('Resources/config/services.yml'));

        $configs = [];

        $instance->load($configs, $container);
    }
}
