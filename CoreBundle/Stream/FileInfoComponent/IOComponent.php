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
namespace Beotie\CoreBundle\Stream\FileInfoComponent;

use Beotie\CoreBundle\Stream\FileInfoStreamAdapter;

/**
 * IO component
 *
 * This trait is used  to implement PSR7\StreamInterface and manage stream Input/Output
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait IOComponent
{
    /**
     * File info
     *
     * This property store the inner file info instance
     *
     * @var \SplFileInfo
     */
    private $fileInfo;

    /**
     * Open mode
     *
     * The file open mode
     *
     * @var string
     */
    private $openMode = 'r';

    /**
     * Get FileObject
     *
     * This method return the open file object
     *
     * @return \SplFileObject
     */
    abstract protected function getFileObject() : ?\SplFileObject;

    /**
     * Returns the remaining contents in a string
     *
     * @throws \RuntimeException if unable to read or an error occurs while
     *     reading.
     * @return string
     */
    public function getContents()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            throw new \RuntimeException('No open stream');
        }

        if ($this->fileInfo->getSize() == 0) {
            return '';
        }

        return $this->getFileObject()->fread($this->fileInfo->getSize());
    }

    /**
     * Returns whether or not the stream is readable.
     *
     * @return bool
     */
    public function isReadable()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            return false;
        }

        return (bool)(FileInfoStreamAdapter::OPEN_MODE[$this->openMode] & 0b10);
    }

    /**
     * Read data from the stream.
     *
     * @param int $length Read up to $length bytes from the object and return
     *                    them. Fewer than $length bytes may be returned if underlying stream
     *                    call returns fewer bytes.
     *
     * @throws \RuntimeException if an error occurs.
     * @return string Returns the data read from the stream, or an empty string
     *     if no bytes are available.
     */
    public function read($length)
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            throw new \RuntimeException('No open stream');
        }

        return $this->getFileObject()->fread($length);
    }

    /**
     * Returns whether or not the stream is writable.
     *
     * @return bool
     */
    public function isWritable()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            return false;
        }

        return (bool)(FileInfoStreamAdapter::OPEN_MODE[$this->openMode] & 0b01);
    }

    /**
     * Write data to the stream.
     *
     * @param string $string The string that is to be written.
     *
     * @throws \RuntimeException on failure.
     * @return int Returns the number of bytes written to the stream.
     */
    public function write($string)
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            throw new \RuntimeException('No open stream');
        }

        return $this->getFileObject()->fwrite($string, strlen($string));
    }
}
