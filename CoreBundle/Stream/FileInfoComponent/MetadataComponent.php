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
 * Metadata component
 *
 * This trait is used  to implement PSR7\StreamInterface and manage stream metadata
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait MetadataComponent
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
     * Get stream metadata as an associative array or retrieve a specific key.
     *
     * The keys returned are identical to the keys returned from PHP's
     * stream_get_meta_data() function.
     *
     * @param string $key Specific metadata to retrieve.
     *
     * @link   http://php.net/manual/en/function.stream-get-meta-data.php
     * @return array|mixed|null Returns an associative array if no key is
     *     provided. Returns a specific key value if a key is provided and the
     *     value is found, or null if the key is not found.
     */
    public function getMetadata($key = null)
    {
        if (!$this->fileInfo) {
            return null;
        }

        $methods = get_class_methods($this->fileInfo);

        array_walk($methods, [$this, 'isMetadataMethod'], sprintf('/^get%s$/i', $key));
        $methods = array_filter($methods);

        if (count($methods) !== 1) {
            $availables = array_filter(array_map([$this, 'getMetadataApplyable'], get_class_methods($this->fileInfo)));
            $message = 'Undefined getter for "%s" metadata. Availables are : [%s]';

            throw new \RuntimeException(sprintf($message, $key, implode(', ', $availables)));
        }

        return $this->fileInfo->{$methods[array_keys($methods)[0]]}();
    }

    /**
     * Get metadata applyable
     *
     * Return the metadata getted by the given method as subject, or false is the method is anot a getter
     *
     * @param string $subject the subject
     *
     * @return boolean|string
     */
    protected function getMetadataApplyable(string $subject)
    {
        if (substr($subject, 0, 3) !== 'get') {
            return false;
        }

        return substr($subject, 3);
    }

    /**
     * Is metadata method
     *
     * Update the method as subject is is not matching the given patter to false
     *
     * @param string $subject The subject
     * @param int    $key     The subject key
     * @param string $pattern The matching pattern
     *
     * @return void
     */
    protected function isMetadataMethod(string &$subject, int $key, string $pattern)
    {
        unset($key);
        if (!preg_match($pattern, $subject)) {
            $subject = false;
        }

        return;
    }
}
