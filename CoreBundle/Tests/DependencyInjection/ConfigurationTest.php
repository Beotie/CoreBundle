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

use Beotie\CoreBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Configuration test
 *
 * This class is used to validate the Configuration
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConfigurationTest extends TestCase
{
    /**
     * Test getConfigTreeBuilder
     *
     * This method validate the Configuration::getConfigTreeBuilder result
     *
     * @return void
     */
    public function testGetConfigTreeBuilder()
    {
        $instance = new Configuration();

        $result = $instance->getConfigTreeBuilder();

        $this->assertInstanceOf(
            TreeBuilder::class,
            $result,
            sprintf(
                'The Configuration::getConfigTreeBuilder is expected to return an instance of %s',
                TreeBuilder::class
            )
        );

        $this->assertEquals(
            'beotie_core',
            $result->buildTree()->getName(),
            sprintf(
                'The TreeBuilder returned by the Configuration::getConfigTreeBuilder is expected to be named "%s"',
                'beotie_core'
            )
        );
    }
}
