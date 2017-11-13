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

/**
 * Position component
 *
 * This trait is used  to implement PSR7\StreamInterface and manage stream cursor position
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait PositionComponent
{
    /**
     * File info
     *
     * This property store the inner file info instance
     *
     * @var \SplFileObject
     */
    private $fileInfo;

    /**
     * Get FileObject
     *
     * This method return the open file object
     *
     * @return \SplFileObject
     */
    abstract protected function getFileObject() : ?\SplFileObject;

    /**
     * Returns whether or not the stream is seekable.
     *
     * @return bool
     */
    public function isSeekable()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            return false;
        }

        return true;
    }

    /**
     * Returns the current position of the file read/write pointer
     *
     * @throws \RuntimeException on error.
     * @return int Position of the file pointer
     */
    public function tell()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            throw new \RuntimeException('No open stream');
        }

        return $this->getFileObject()->ftell();
    }

    /**
     * Seek to a position in the stream.
     *
     * @param int $offset Stream offset
     * @param int $whence Specifies how the cursor position will be calculated
     *                    based on the seek offset. Valid values are identical to the built-in
     *                    PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
     *                    offset bytes SEEK_CUR: Set position to current location plus offset
     *                    SEEK_END: Set position to end-of-stream plus offset.
     *
     * @link   http://www.php.net/manual/en/function.fseek.php
     * @throws \RuntimeException on failure.
     * @return int
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            throw new \RuntimeException('No open stream');
        }

        return $this->getFileObject()->fseek($offset, $whence);
    }

    /**
     * Get the size of the stream if known.
     *
     * @return int|null Returns the size in bytes if known, or null if unknown.
     */
    public function getSize()
    {
        if (!$this->fileInfo) {
            return null;
        }

        return $this->fileInfo->getSize();
    }

    /**
     * Seek to the beginning of the stream.
     *
     * If the stream is not seekable, this method will raise an exception;
     * otherwise, it will perform a seek(0).
     *
     * @see    seek()
     * @link   http://www.php.net/manual/en/function.fseek.php
     * @throws \RuntimeException on failure.
     * @return void
     */
    public function rewind()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            throw new \RuntimeException('No open stream');
        }

        return $this->getFileObject()->rewind();
    }

    /**
     * Returns true if the stream is at the end of the stream.
     *
     * @return bool
     */
    public function eof()
    {
        if (!$this->fileInfo || !$this->getFileObject()) {
            return true;
        }

        return $this->getFileObject()->eof();
    }
}
