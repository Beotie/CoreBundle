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
namespace Beotie\CoreBundle\Tests\Stream;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Stream\FileInfoStreamAdapter;
use Beotie\CoreBundle\Tests\Stream\FileInfoComponent\TestIOComponent;
use Beotie\CoreBundle\Tests\Stream\FileInfoComponent\TestMetadataComponent;
use Beotie\CoreBundle\Tests\Stream\FileInfoComponent\TestPositionComponent;

/**
 * FileInfoStreamAdapter test
 *
 * This class is used to validate the FileInfoStreamAdapter class
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FileInfoStreamAdapterTest extends TestCase
{
    use TestIOComponent,
    TestMetadataComponent,
    TestPositionComponent;

    /**
     * File name
     *
     * This constant indicate the fixture file location
     *
     * @var string
     */
    const FILE_NAME = __DIR__.DIRECTORY_SEPARATOR.'Fixture'.DIRECTORY_SEPARATOR.'StreamAdapterFixture.txt';

    /**
     * File name
     *
     * This constant indicate the empty fixture file location
     *
     * @var string
     */
    const EMPTY_FILE_NAME = __DIR__.DIRECTORY_SEPARATOR.'Fixture'.DIRECTORY_SEPARATOR.'StreamAdapterEmptyFixture.txt';

    /**
     * File info provider
     *
     * This method return a set of fixtures to validate a FileInfoStreamAdapter instance
     *
     * @return [[\SplFileInfo]]
     */
    public function fileInfoProvider() : array
    {
        return [
            [$this->getFileInfo()],
            [$this->getEmptyFileInfo()]
        ];
    }

    /**
     * Test construct
     *
     * This method is used to validate the FileInfoStreamAdapter::__construct method
     *
     * @param \SplFileInfo $fileInfo The file info to use
     *
     * @dataProvider fileInfoProvider
     * @return       void
     */
    public function testConstructor(\SplFileInfo $fileInfo) : void
    {
        $instance = new FileInfoStreamAdapter($fileInfo);
        $reflexProperty = $this->getFileInfoReflection();

        $this->assertSame(
            $fileInfo,
            $reflexProperty->getValue($instance),
            sprintf(
                'The "%s" constructor is expected to set the instance "$fileInfo" property',
                FileInfoStreamAdapter::class
            )
        );

        $reflexObject = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileObject');
        $reflexObject->setAccessible(true);

        $this->assertInstanceOf(
            \SplFileObject::class,
            $reflexObject->getValue($instance),
            sprintf(
                'The "%s" constructor is expected to set the instance "$fileObject" property',
                FileInfoStreamAdapter::class
            )
        );

        return;
    }

    /**
     * Test toString
     *
     * This method is used to validate the FileInfoStreamAdapter::__toString method
     *
     * @param \SplFileInfo $fileInfo The file info to use
     *
     * @dataProvider fileInfoProvider
     * @return       void
     */
    public function testToString(\SplFileInfo $fileInfo) : void
    {
        $instance = $this->getEmptyInstance();
        $reflexProperty = $this->getFileInfoReflection();

        $this->assertEquals(
            '',
            $instance->__toString(),
            sprintf(
                'The "%s" __toString method is expected to return an empty string in case of inexistant fileInfo',
                FileInfoStreamAdapter::class
            )
        );

        $reflexProperty->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile());

        $content = file_get_contents($fileInfo->getPathname());

        $this->assertEquals(
            $content,
            $instance->__toString(),
            sprintf(
                'The "%s" __toString method is expected to return the file content corresponding with the fileInfo',
                FileInfoStreamAdapter::class
            )
        );

        return;
    }

    /**
     * Test detach
     *
     * This method is used to validate the FileInfoStreamAdapter::detach method
     *
     * @param \SplFileInfo $fileInfo The file info to use
     *
     * @dataProvider fileInfoProvider
     * @return       void
     */
    public function testDetach(\SplFileInfo $fileInfo) : void
    {
        $instance = $this->getEmptyInstance();
        $reflexProperty = $this->getFileInfoReflection();

        $reflexProperty->setValue($instance, $fileInfo);

        $this->assertSame(
            $fileInfo,
            $instance->detach(),
            sprintf(
                'The "%s" detach method is expected to return the fileInfo instance',
                FileInfoStreamAdapter::class
            )
        );

        $this->assertNull(
            $reflexProperty->getValue($instance),
            sprintf(
                'The "%s" detach method is expected to erase the fileInfo instance',
                FileInfoStreamAdapter::class
            )
        );

        return;
    }

    /**
     * Test detach
     *
     * This method is used to validate the FileInfoStreamAdapter::close method
     *
     * @param \SplFileInfo $fileInfo The file info to use
     *
     * @dataProvider fileInfoProvider
     * @return       void
     */
    public function testClose(\SplFileInfo $fileInfo) : void
    {
        $instance = $this->getEmptyInstance();
        $reflexProperty = $this->getFileInfoReflection();

        $reflexProperty->setValue($instance, $fileInfo);
        $instance->close();

        $this->assertNull(
            $reflexProperty->getValue($instance),
            sprintf(
                'The "%s" close method is expected to erase the fileInfo instance',
                FileInfoStreamAdapter::class
            )
        );

        $reflexObject = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileObject');
        $reflexObject->setAccessible(true);

        $this->assertNull(
            $reflexObject->getValue($instance),
            sprintf(
                'The "%s" close method is expected to erase the fileObject instance',
                FileInfoStreamAdapter::class
            )
        );

        return;
    }

    /**
     * Test getFileObject
     *
     * This method is used to validate the FileInfoStreamAdapter::getFileObject method
     *
     * @param \SplFileInfo $fileInfo The file info to use
     *
     * @dataProvider fileInfoProvider
     * @return       void
     */
    public function testGetFileObject(\SplFileInfo $fileInfo) : void
    {
        $instance = $this->getEmptyInstance();
        $reflexProperty = $this->getFileInfoReflection();
        $reflexProperty->setValue($instance, $fileInfo);

        $reflexMethod = new \ReflectionMethod(sprintf('%s::%s', FileInfoStreamAdapter::class, 'getFileObject'));
        $reflexMethod->setAccessible(true);

        $reflexObject = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileObject');
        $reflexObject->setAccessible(true);

        $fileObject = $fileInfo->openFile();
        $reflexObject->setValue($instance, $fileObject);

        $this->assertSame(
            $fileObject,
            $reflexMethod->invoke($instance),
            sprintf(
                'The "%s" getFileObject method is expected to return the fileObject instance',
                FileInfoStreamAdapter::class
            )
        );

        $instance = $this->getEmptyInstance();
        $this->assertNull(
            $reflexMethod->invoke($instance),
            sprintf(
                'The "%s" getFileObject method is expected to return null if no fileObject',
                FileInfoStreamAdapter::class
            )
        );

        return;
    }

    /**
     * Get TestCase
     *
     * This method return a TestCase instance
     *
     * @return TestCase
     */
    protected function getTestCase() : TestCase
    {
        return $this;
    }

    /**
     * Get fixtureFilePath
     *
     * This method return the path name of the fixture file
     *
     * @return string
     */
    protected function getFixtureFilePath() : string
    {
        return self::FILE_NAME;
    }

    /**
     * Get fileInfo
     *
     * This method return an instance of file info to be used as fixture
     *
     * @return \SplFileInfo
     */
    protected function getFileInfo() : \SplFileInfo
    {
        return new \SplFileInfo(static::FILE_NAME);
    }

    /**
     * Get emptyFileInfo
     *
     * This method return an instance of file info to be used as fixture
     *
     * @return \SplFileInfo
     */
    protected function getEmptyFileInfo() : \SplFileInfo
    {
        return new \SplFileInfo(static::EMPTY_FILE_NAME);
    }

    /**
     * Get FileInfo reflection
     *
     * This method return the fileInfo property reflection of the tested instance
     *
     * @return \ReflectionProperty
     */
    protected function getFileInfoReflection() : \ReflectionProperty
    {
        $reflexProperty = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileInfo');
        $reflexProperty->setAccessible(true);

        return $reflexProperty;
    }

    /**
     * Get FileObject reflection
     *
     * This method return the fileObject property reflection of the tested instance
     *
     * @return \ReflectionProperty
     */
    protected function getFileObjectReflection() : \ReflectionProperty
    {
        $reflexProperty = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileObject');
        $reflexProperty->setAccessible(true);

        return $reflexProperty;
    }

    /**
     * Get OpenMode reflection
     *
     * This method return the openMode property reflection of the tested instance
     *
     * @return \ReflectionProperty
     */
    protected function getOpenModeReflection() : \ReflectionProperty
    {
        $reflexProperty = new \ReflectionProperty(FileInfoStreamAdapter::class, 'openMode');
        $reflexProperty->setAccessible(true);

        return $reflexProperty;
    }

    /**
     * Get empty instance
     *
     * This method return an empty instance to be tested
     *
     * @return FileInfoStreamAdapter
     */
    protected function getEmptyInstance() : FileInfoStreamAdapter
    {
        $reflectionClass = new \ReflectionClass(FileInfoStreamAdapter::class);
        $instance = $reflectionClass->newInstanceWithoutConstructor();

        return $instance;
    }
}
