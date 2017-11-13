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
namespace Beotie\CoreBundle\Tests\Stream\Factory;

use PHPUnit\Framework\TestCase;
use Beotie\CoreBundle\Stream\Factory\FileInfoStreamFactory;
use Beotie\CoreBundle\Stream\FileInfoStreamAdapter;

/**
 * File info streal factory test
 *
 * This class is used to validate the FileInfoStreamFactory
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FileInfoStreamFactoryTest extends TestCase
{
    /**
     * Parent dir
     *
     * This constant indicate the parent directory of this file
     *
     * @var string
     */
    const PARENT_DIR = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;

    /**
     * File name
     *
     * This constant indicate the fixture file location
     *
     * @var string
     */
    const FILE_NAME = self::PARENT_DIR.'Fixture'.DIRECTORY_SEPARATOR.'StreamAdapterFixture.txt';

    /**
     * Test getArrayKey
     *
     * This method is used to validate the FileInfoStreamFactory::getArrayKey method
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetArrayKey() : void
    {
        $this->assertEquals(
            'inner_content',
            FileInfoStreamFactory::getArrayKey()
        );

        return;
    }

    /**
     * Test getOpenMode
     *
     * This method is used to validate the FileInfoStreamFactory::getOpenMode method
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetOpenMode() : void
    {
        $this->assertEquals(
            'open_mode',
            FileInfoStreamFactory::getOpenMode()
        );

        return;
    }

    /**
     * Get stream argument provider
     *
     * This method return a getStream argument
     *
     * @return                               [[[\SplFileInfo, ?string]]]
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getStreamArgumentProvider()
    {
        $fileInfo = $this->getFileInfo();

        return [
            [[FileInfoStreamFactory::getArrayKey() => $fileInfo]],
            [[FileInfoStreamFactory::getArrayKey() => $fileInfo, FileInfoStreamFactory::getOpenMode() => 'r+']],
            [[FileInfoStreamFactory::getArrayKey() => $fileInfo, FileInfoStreamFactory::getOpenMode() => 'a']]
        ];
    }

    /**
     * Test getStream
     *
     * This method is used to validate the FileInfoStreamFactory::getStream method
     *
     * @param array $getStreamArg The getStream argument
     *
     * @dataProvider                         getStreamArgumentProvider
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetStream(array $getStreamArg) : void
    {
        $fileInfo = $getStreamArg[FileInfoStreamFactory::getArrayKey()];
        $instance = new FileInfoStreamFactory();

        $stream = $instance->getStream($getStreamArg);

        $this->assertInstanceOf(
            FileInfoStreamAdapter::class,
            $stream,
            sprintf(
                'The "%s::getStream" method is expected to return an instance of "%s". "%s" given',
                FileInfoStreamFactory::class,
                FileInfoStreamAdapter::class,
                is_object($stream) ? get_class($stream) : gettype($stream)
            )
        );

        $fileInfoReflex = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileInfo');
        $fileInfoReflex->setAccessible(true);
        $this->assertSame(
            $fileInfo,
            $fileInfoReflex->getValue($stream),
            sprintf(
                'The "%s" object returned by the "%s::getStream" method is expected to contain the given fileInfo',
                FileInfoStreamAdapter::class,
                FileInfoStreamFactory::class
            )
        );

        $fileObjectReflex = new \ReflectionProperty(FileInfoStreamAdapter::class, 'fileObject');
        $fileObjectReflex->setAccessible(true);
        $this->assertInstanceOf(
            \SplFileObject::class,
            $fileObjectReflex->getValue($stream),
            sprintf(
                'The "%s" object is expected to store the fileObject open by the given fileInfo',
                FileInfoStreamAdapter::class
            )
        );

        if (!isset($getStreamArg[FileInfoStreamFactory::getOpenMode()])) {
            return;
        }

        $openModeReflex = new \ReflectionProperty(FileInfoStreamAdapter::class, 'openMode');
        $openModeReflex->setAccessible(true);
        $this->assertEquals(
            $getStreamArg[FileInfoStreamFactory::getOpenMode()],
            $openModeReflex->getValue($stream),
            sprintf(
                'The "%s" object is expected to store the open mode of the fileObject',
                FileInfoStreamAdapter::class
            )
        );

        return;
    }

    /**
     * Test getStream type failure
     *
     * This method is used to validate the FileInfoStreamFactory::getStream method in case of wrong argument type
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetStreamTypeFailure()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The "%s::getStream" expect the file array key to be an instance of "SplFileInfo". "stdClass" given',
                FileInfoStreamFactory::class
            )
        );

        $object = new \stdClass();
        $instance = new FileInfoStreamFactory();
        $instance->getStream([FileInfoStreamFactory::getArrayKey() => $object]);
    }

    /**
     * Test getStream type failure
     *
     * This method is used to validate the FileInfoStreamFactory::getStream method in case of wrong key argument
     *
     * @return void
     */
    public function testGetStreamKeyFailure()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The "%s::getStream" expect a file array key to build an instance of FileInfoStreamAdapter',
                FileInfoStreamFactory::class
            )
        );

        $object = new \stdClass();
        $instance = new FileInfoStreamFactory();
        $instance->getStream(['key' => $object]);
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
}
