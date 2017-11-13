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

use Beotie\CoreBundle\Stream\FileInfoComponent\PositionComponent;

/**
 * Test PositionComponent
 *
 * This class is used to validate the PositionComponent trait
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait TestPositionComponent
{
    use BaseTestComponent;

    /**
     * Test isSeekable
     *
     * This method is used to validate the PositionComponent::isSeekable method
     *
     * @return void
     */
    public function testIsSeekable() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();

        $this->getTestCase()
            ->assertFalse(
                $instance->isSeekable(),
                sprintf(
                    'The "%s::isSeekable" is expected to return false with empty stream',
                    PositionComponent::class
                )
            );

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile());

        $this->getTestCase()
            ->assertTrue(
                $instance->isSeekable(),
                sprintf(
                    'The "%s::isSeekable" is expected to return true with loaded stream',
                    PositionComponent::class
                )
            );

        return;
    }

    /**
     * Test tell
     *
     * This method is used to validate the PositionComponent::tell method
     *
     * @return void
     */
    public function testTell() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $fileObject = $fileInfo->openFile();

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileObject);

        while (!$fileObject->eof()) {
            $this->getTestCase()->assertEquals(
                $fileObject->ftell(),
                $instance->tell(),
                sprintf(
                    'The "%s::tell" is expected to return the stream pointer position',
                    PositionComponent::class
                )
            );
            $fileObject->fgetc();
        }

        return;
    }

    /**
     * Test tell failure
     *
     * This method is used to validate the PositionComponent::tell method in case of no fileObject
     *
     * @return void
     */
    public function testTellFailure() : void
    {
        $this->getTestCase()->expectException(\RuntimeException::class);
        $this->getTestCase()->expectExceptionMessage('No open stream');

        $instance = $this->getEmptyInstance();
        $instance->tell();

        return;
    }

    /**
     * Test seek
     *
     * This method is used to validate the PositionComponent::seek method
     *
     * @return void
     */
    public function testSeek() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $fileObject = $fileInfo->openFile();

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileObject);

        $tell = 30;
        $instance->seek($tell, SEEK_SET);
        $this->getTestCase()->assertEquals(
            $tell,
            $fileObject->ftell(),
            sprintf(
                'The "%s::seek" is expected to set the stream pointer position',
                PositionComponent::class
            )
        );

        return;
    }

    /**
     * Test seek failure
     *
     * This method is used to validate the PositionComponent::seek method in case of no fileObject
     *
     * @return void
     */
    public function testSeekFailure() : void
    {
        $this->getTestCase()->expectException(\RuntimeException::class);
        $this->getTestCase()->expectExceptionMessage('No open stream');

        $instance = $this->getEmptyInstance();
        $instance->seek(30);

        return;
    }

    /**
     * Test getSize
     *
     * This method is used to validate the PositionComponent::getSize method
     *
     * @return void
     */
    public function testGetSize() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();

        $this->getTestCase()
            ->assertNull(
                $instance->getSize(),
                sprintf(
                    'The "%s::getSize" is expected to return null on undefined fileInfo',
                    PositionComponent::class
                )
            );

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);

        $this->getTestCase()->assertEquals(
            $fileInfo->getSize(),
            $instance->getSize(),
            sprintf(
                'The "%s::getSize" is expected to return the file info size',
                PositionComponent::class
            )
        );

        return;
    }

    /**
     * Test rewind
     *
     * This method is used to validate the PositionComponent::rewind method
     *
     * @return void
     */
    public function testRewind() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $fileObject = $fileInfo->openFile();

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileObject);

        $fileObject->fseek(30);
        $instance->rewind();
        $this->getTestCase()
            ->assertEquals(
                0,
                $fileObject->ftell(),
                sprintf(
                    'The "%s::rewind" is expected to reset the stream pointer position to 0',
                    PositionComponent::class
                )
            );

        return;
    }

    /**
     * Test rewind failure
     *
     * This method is used to validate the PositionComponent::rewind method in case of no fileObject
     *
     * @return void
     */
    public function testRewindFailure() : void
    {
        $this->getTestCase()->expectException(\RuntimeException::class);
        $this->getTestCase()->expectExceptionMessage('No open stream');

        $instance = $this->getEmptyInstance();
        $instance->rewind();

        return;
    }

    /**
     * Test eof
     *
     * This method is used to validate the PositionComponent::eof method
     *
     * @return void
     */
    public function testEof() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $fileObject = $fileInfo->openFile();

        $this->getTestCase()
            ->assertTrue(
                $instance->eof(),
                sprintf(
                    'The "%s::eof" is expected to return true on undefined file object',
                    PositionComponent::class
                )
            );

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileObject);


        $this->getTestCase()
            ->assertFalse(
                $instance->eof(),
                sprintf(
                    'The "%s::eof" is expected to return false if stream pointer not at file end',
                    PositionComponent::class
                )
            );

        $fileObject->fseek($fileInfo->getSize());
        $fileObject->fgetc();
        $this->getTestCase()
            ->assertTrue(
                $instance->eof(),
                sprintf(
                    'The "%s::eof" is expected to return true on end of file',
                    PositionComponent::class
                )
            );

        return;
    }
}
