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

use Beotie\CoreBundle\Stream\FileInfoComponent\MetadataComponent;

/**
 * Test MetadataComponent
 *
 * This class is used to validate the MetadataComponent trait
 *
 * @category Test
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait TestMetadataComponent
{
    use BaseTestComponent;

    /**
     * Metadata key provider
     *
     * This method return a set of metadata with real file info method to validate the MetadataComponent
     *
     * @return array
     */
    public function metadataKeyProvider() : array
    {
        return [
            ['atime', 'getATime'],
            ['basename', 'getBasename'],
            ['ctime', 'getCTime'],
            ['extension', 'getExtension'],
            ['fileinfo', 'getFileInfo'],
            ['filename', 'getFilename'],
            ['group', 'getGroup'],
            ['inode', 'getInode'],
            ['mtime', 'getMTime'],
            ['owner', 'getOwner'],
            ['path', 'getPath'],
            ['pathinfo', 'getPathInfo'],
            ['pathname', 'getPathname'],
            ['perms', 'getPerms'],
            ['realpath', 'getRealPath'],
            ['size', 'getSize'],
            ['type', 'getType']
        ];
    }

    /**
     * Test getMetadata
     *
     * This method is used to validate the MetadataComponent::getMetadata method
     *
     * @param string $metaKey    The metadata key to search
     * @param string $realMethod The fileInfo metadata getter method name
     *
     * @dataProvider metadataKeyProvider
     * @return       void
     */
    public function testGetMetadata(string $metaKey, string $realMethod) : void
    {
        $fileInfo = $this->getFileInfo();
        $instance = $this->getEmptyInstance();

        $this->getTestCase()
            ->assertNull(
                $instance->getMetadata($metaKey),
                sprintf(
                    'The "%s::getMetadata" with parameter "%s" is expected to return null when no fileInfo exist',
                    MetadataComponent::class,
                    $metaKey
                )
            );

        $this->getFileInfoReflection()->setValue($instance, $fileInfo);

        $this->getTestCase()
            ->assertEquals(
                $fileInfo->{$realMethod}(),
                $instance->getMetadata($metaKey),
                sprintf(
                    'The "%s::getMetadata" with parameter "%s" is expected to return the fileInfo metadata',
                    MetadataComponent::class,
                    $metaKey
                )
            );

        return;
    }

    /**
     * No metadata key provider
     *
     * This method return a set of unexisting metadata to validate the MetadataComponent
     *
     * @return array
     */
    public function noMetadataKeyProvider() : array
    {
        return [
            ['isDir'],
            ['isExecutable'],
            ['isFile'],
            ['isLink'],
            ['isReadable'],
            ['isWritable'],
            ['openFile'],
            ['setFileClass'],
            ['setInfoClass'],
            ['dir'],
            ['executable'],
            ['file'],
            ['link'],
            ['readable'],
            ['writable'],
            ['openFile'],
            ['fileClass'],
            ['infoClass'],
            ['meta']
        ];
    }

    /**
     * Test getMetadata
     *
     * This method is used to validate the MetadataComponent::getMetadata method
     *
     * @param string $metaKey The metadata key to search
     *
     * @dataProvider noMetadataKeyProvider
     * @return       void
     */
    public function testGetMetadataFailure(string $metaKey) : void
    {
        $this->getTestCase()->expectException(\RuntimeException::class);

        $errorRegex = sprintf(
            '/Undefined getter for "%s" metadata\. Availables are : \[([a-zA-Z]+, )+[a-zA-Z]+\]/',
            $metaKey
        );
        $this->getTestCase()->expectExceptionMessageRegExp($errorRegex);

        $fileInfo = $this->getFileInfo();
        $instance = $this->getEmptyInstance();
        $this->getFileInfoReflection()->setValue($instance, $fileInfo);

        $instance->getMetadata($metaKey);

        return;
    }
}
