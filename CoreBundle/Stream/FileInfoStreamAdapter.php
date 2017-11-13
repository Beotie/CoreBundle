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
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Stream;

use Psr\Http\Message\StreamInterface;
use Beotie\CoreBundle\Stream\FileInfoComponent as Component;
use Beotie\CoreBundle\Stream\FileInfoComponent\IOComponent;

/**
 * File info stream adapter
 *
 * This class is used as file info adapter to implement PSR7\StreamInterface
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FileInfoStreamAdapter implements StreamInterface
{
    use Component\PositionComponent,
        Component\MetadataComponent,
        IOComponent;

    /**
     * Open mode
     *
     * This constant store the usable open mode
     *
     * @var array
     */
    private const OPEN_MODE = [
        'r' => 0b10,
        'r+' => 0b11,
        'w' => 0b01,
        'w+' => 0b11,
        'a' => 0b01,
        'a+' => 0b11,
        'x' => 0b01,
        'x+' => 0b11,
        'c' => 0b01,
        'c+' => 0b11
    ];

    /**
     * File info
     *
     * This property store the inner file info instance
     *
     * @var \SplFileObject
     */
    private $fileInfo;

    /**
     * File object
     *
     * The stream file object
     *
     * @var \SplFileObject
     */
    private $fileObject;

    /**
     * Open mode
     *
     * The file open mode
     *
     * @var string
     */
    private $openMode = 'r';

    /**
     * Construct
     *
     * The default StreamAdapter constructor
     *
     * @param \SplFileInfo $innerFileInfo The inner file info
     * @param string       $openMode      The file open mode
     *
     * @return void
     */
    public function __construct(\SplFileInfo $innerFileInfo, $openMode = 'r')
    {
        $this->fileInfo = $innerFileInfo;

        $this->openMode = $openMode;
        $this->fileObject = $this->fileInfo->openFile($openMode);
    }

    /**
     * Reads all data from the stream into a string, from the beginning to end.
     *
     * This method MUST attempt to seek to the beginning of the stream before
     * reading data and read the stream until the end is reached.
     *
     * Warning: This could attempt to load a large amount of data into memory.
     *
     * This method MUST NOT raise an exception in order to conform with PHP's
     * string casting operations.
     *
     * @see    http://php.net/manual/en/language.oop5.magic.php#object.tostring
     * @return string
     */
    public function __toString()
    {
        if (!$this->fileInfo) {
            return '';
        }

        return $this->getContents();
    }

    /**
     * Separates any underlying resources from the stream.
     *
     * After the stream has been detached, the stream is in an unusable state.
     *
     * @return resource|null Underlying PHP stream, if any
     */
    public function detach()
    {
        $result = $this->fileInfo;
        $this->close();
        return $result;
    }

    /**
     * Closes the stream and any underlying resources.
     *
     * @return void
     */
    public function close()
    {
        $this->fileInfo = null;
        $this->fileObject = null;

        return;
    }

    /**
     * Get FileObject
     *
     * This method return the open file object
     *
     * @return \SplFileObject
     */
    protected function getFileObject() : ?\SplFileObject
    {
        if (!$this->fileObject) {
            return null;
        }

        return $this->fileObject;
    }
}
