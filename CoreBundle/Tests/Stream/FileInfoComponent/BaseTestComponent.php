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
namespace Beotie\CoreBundle\Tests\Stream\FileInfoComponent;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Stream\FileInfoStreamAdapter;

/**
 * Base test component
 *
 * This class is used to validate the components trait
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait BaseTestComponent
{
    /**
     * Get TestCase
     *
     * This method return a TestCase instance
     *
     * @return TestCase
     */
    abstract protected function getTestCase() : TestCase;

    /**
     * Get fixtureFilePath
     *
     * This method return the path name of the fixture file
     *
     * @return string
     */
    abstract protected function getFixtureFilePath() : string;

    /**
     * Get fileInfo
     *
     * This method return an instance of file info to be used as fixture
     *
     * @return \SplFileInfo
     */
    abstract protected function getFileInfo() : \SplFileInfo;

    /**
     * Get FileObject reflection
     *
     * This method return the fileObject property reflection of the tested instance
     *
     * @return \ReflectionProperty
     */
    abstract protected function getFileObjectReflection() : \ReflectionProperty;

    /**
     * Get FileInfo reflection
     *
     * This method return the fileInfo property reflection of the tested instance
     *
     * @return \ReflectionProperty
     */
    abstract protected function getFileInfoReflection() : \ReflectionProperty;

    /**
     * Get empty instance
     *
     * This method return an empty instance to be tested
     *
     * @return FileInfoStreamAdapter
     */
    abstract protected function getEmptyInstance() : FileInfoStreamAdapter;

    /**
     * Get OpenMode reflection
     *
     * This method return the openMode property reflection of the tested instance
     *
     * @return \ReflectionProperty
     */
    abstract protected function getOpenModeReflection() : \ReflectionProperty;
}
