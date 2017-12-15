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
namespace Beotie\CoreBundle\Tests\Request\Uri\StringUri;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Request\Uri\StringUri;

/**
 * StringUri user info part
 *
 * This trait is used to validate the StringUri instance relative to user info management
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait StringUriUserInfoPart
{
    /**
     * User info provider
     *
     * This method provide a set of user info to validate the StringUri methods
     *
     * @return [[string|null]]
     */
    public function userInfoProvider()
    {
        return  [
            ['user', 'password', 'user:password'],
            ['user', null, 'user'],
            [null, 'password', ':password'],
            [null, null, '']
        ];
    }

    /**
     * Test getUserInfo
     *
     * This method validate the StringUri::getUserInfo method
     *
     * @param string|null $user     The user to use as user name
     * @param string|null $pass     The pass to use as user password
     * @param string      $expected The expectation of the getUserInfo method result
     *
     * @dataProvider userInfoProvider
     * @return       void
     * @covers       Beotie\CoreBundle\Request\Uri\StringUri::getUserInfo
     */
    public function testGetUserInfo(?string $user, ?string $pass, string $expected) : void
    {
        $reflex = new \ReflectionClass(StringUri::class);
        $instance = $reflex->newInstanceWithoutConstructor();

        if ($user) {
            $userProperty = $reflex->getProperty('user');
            $userProperty->setAccessible(true);
            $userProperty->setValue($instance, $user);
        }

        if ($pass) {
            $passProperty = $reflex->getProperty('pass');
            $passProperty->setAccessible(true);
            $passProperty->setValue($instance, $pass);
        }

        $this->getTestCase()->assertEquals($expected, $instance->getUserInfo());
    }

    /**
     * Get test case
     *
     * This method return the current test case to be used as assertion provider
     *
     * @return TestCase
     */
    protected abstract function getTestCase() : TestCase;
}
