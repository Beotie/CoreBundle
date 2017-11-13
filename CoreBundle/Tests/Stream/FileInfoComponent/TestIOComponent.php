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

use Beotie\CoreBundle\Stream\FileInfoComponent\IOComponent;

/**
 * Test IOComponent
 *
 * This class is used to validate the IOComponent trait
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait TestIOComponent
{
    use BaseTestComponent;

    /**
     * Test getContents
     *
     * This method is used to validate the IOComponent::getContents method
     *
     * @return void
     */
    public function testGetContents() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $reflexProperty = $this->getFileInfoReflection();

        $reflexProperty->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile());

        $this->getTestCase()
            ->assertEquals(
                file_get_contents(
                    $this->getFixtureFilePath()
                ),
                $instance->getContents(),
                sprintf(
                    'The "%s" getContents method is expected to return the file content',
                    IOComponent::class
                )
            );

        $this->getTestCase()->expectException(\RuntimeException::class);
        $this->getTestCase()->expectExceptionMessage('No open stream');

        $instance = $this->getEmptyInstance();
        $instance->getContents();

        $this->getTestCase()
            ->fail(
                sprintf(
                    'The "%s" getContents method is expected to throw exception in case of empty fileInfo',
                    IOComponent::class
                )
            );
        return;
    }

    /**
     * Test isReadable
     *
     * This method is used to validate the IOComponent::isReadable method
     *
     * @return void
     */
    public function testIsReadable() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile('r'));
        $this->getOpenModeReflection()->setValue($instance, 'r');

        $this->getTestCase()
            ->assertTrue(
                $instance->isReadable(),
                sprintf(
                    'The "%s" isReadable method is expected to return true',
                    IOComponent::class
                )
            );

        $instance = $this->getEmptyInstance();

        $this->getTestCase()
            ->assertFalse(
                $instance->isReadable(),
                sprintf(
                    'The "%s" isReadable method is expected to return false when fileInfo is empty',
                    IOComponent::class
                )
            );

        return;
    }

    /**
     * Test read
     *
     * This method is used to validate the IOComponent::read method
     *
     * @return void
     */
    public function testRead() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $reflexProperty = $this->getFileInfoReflection();

        $reflexProperty->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile());
        $content = file_get_contents($this->getFixtureFilePath());

        $this->getTestCase()
            ->assertEquals(
                substr($content, 0, 10),
                $instance->read(10),
                sprintf(
                    'The "%s" read method is expected to return the file content length',
                    IOComponent::class
                )
            );

        $this->getTestCase()->expectException(\RuntimeException::class);
        $this->getTestCase()->expectExceptionMessage('No open stream');

        $instance = $this->getEmptyInstance();
        $instance->read(10);

        $this->getTestCase()
            ->fail(
                sprintf(
                    'The "%s" read method is expected to throw exception in case of empty fileInfo',
                    IOComponent::class
                )
            );

        return;
    }

    /**
     * Test isWritable
     *
     * This method is used to validate the IOComponent::isWritable method
     *
     * @return void
     */
    public function testIsWritable() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile('r+'));
        $this->getOpenModeReflection()->setValue($instance, 'r+');

        $this->getTestCase()
            ->assertTrue(
                $instance->isWritable(),
                sprintf(
                    'The "%s" isWritable method is expected to return true',
                    IOComponent::class
                )
            );

        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile('r'));
        $this->getOpenModeReflection()->setValue($instance, 'r');

        $this->getTestCase()
            ->assertFalse(
                $instance->isWritable(),
                sprintf(
                    'The "%s" isWritable method is expected to return false',
                    IOComponent::class
                )
            );

        $instance = $this->getEmptyInstance();

        $this->getTestCase()
            ->assertFalse(
                $instance->isWritable(),
                sprintf(
                    'The "%s" isWritable method is expected to return false when fileInfo is empty',
                    IOComponent::class
                )
            );

        return;
    }

    /**
     * Test write
     *
     * This method is used to validate the IOComponent::write method
     *
     * @return void
     */
    public function testWrite() : void
    {
        $instance = $this->getEmptyInstance();
        $fileInfo = $this->getFileInfo();
        $reflexProperty = $this->getFileInfoReflection();

        $reflexProperty->setValue($instance, $fileInfo);
        $this->getFileObjectReflection()->setValue($instance, $fileInfo->openFile('r+'));

        $string = 'stream:';
        $this->getTestCase()->assertEquals(strlen($string), $instance->write($string));

        $this->getTestCase()->expectException(\RuntimeException::class);
        $this->getTestCase()->expectExceptionMessage('No open stream');
        $instance = $this->getEmptyInstance();

        $instance->write($string);

        $this->getTestCase()
            ->fail(
                sprintf(
                    'The "%s" write method is expected to throw exception in case of empty fileInfo',
                    IOComponent::class
                )
            );


        return;
    }
}
