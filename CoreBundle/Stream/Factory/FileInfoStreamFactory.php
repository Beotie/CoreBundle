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
namespace Beotie\CoreBundle\Stream\Factory;

use Beotie\CoreBundle\Stream\FileInfoStreamAdapter;
use Psr\Http\Message\StreamInterface;

/**
 * FileInfo stream factory
 *
 * This class is used to build FileInfoStreamAdapter instance with embedded SplFileInfo instance
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FileInfoStreamFactory extends AbstractEmbeddedStreamFactory
{
    /**
     * Open mode
     *
     * This constant define the array key name where is store the open file mode
     *
     * @var string
     */
    protected const OPEN_MODE = 'open_mode';

    /**
     * Get open mode
     *
     * This method return the expected array key to retreive the open mode
     *
     * @return string
     */
    public static function getOpenMode() : string
    {
        return self::OPEN_MODE;
    }

    /**
     * Get array key
     *
     * This method return the expected array key to retreive the embedded content
     *
     * @return string
     */
    public static function getArrayKey() : string
    {
        return self::ARRAY_KEY;
    }

    /**
     * Get stream
     *
     * This method return a stream instance. The optional params parameter can be used to provide constructor or
     * setter arguments during the instanciation.
     *
     * @param array $params [required] the instanciation parameters
     *
     * @throws \RuntimeException If the given parameters does not have a 'inner_content' key
     * @throws \RuntimeException If the given content does not match the expected SplFileInfo type
     * @return StreamInterface
     */
    public function getStream(array $params = []) : StreamInterface
    {
        $this->paramHasContent($params);
        $this->contentIsFileInfo($params[self::ARRAY_KEY]);

        $openMode = 'r';
        if (!empty($params[self::OPEN_MODE])) {
            $openMode = $params[self::OPEN_MODE];
        }

        return new FileInfoStreamAdapter($params[self::ARRAY_KEY], $openMode);
    }

    /**
     * Param has content
     *
     * This method aim to validate the existance of a 'inner_content' key into the parameters array.
     *
     * @param array  $params The original method parameters validated by the function
     * @param string $method The original method name. This parameter is used to build the exception message
     *
     * @throws \RuntimeException If the given parameters does not have a 'inner_content' key
     * @return bool
     */
    protected function paramHasContent(array $params, string $method = 'getStream') : bool
    {
        if (!array_key_exists(self::ARRAY_KEY, $params)) {
            throw new \RuntimeException(
                sprintf(
                    'The "%s::%s" expect a file array key to build an instance of FileInfoStreamAdapter',
                    static::class,
                    $method
                )
            );
        }

        return true;
    }

    /**
     * Content is FileInfo
     *
     * This method validate the instance of the given content parameter. This type is expected to be SplFileInfo.
     *
     * @param mixed  $file   The file which the method aim to validate the type
     * @param string $method The original method name. This parameter is used to define the exception message
     *
     * @throws \RuntimeException If the given content does not match the expected type
     * @return bool
     */
    protected function contentIsFileInfo($file, string $method = 'getStream') : bool
    {
        if (! $file instanceof \SplFileInfo) {
            $message = 'The "%s::%s" expect the file array key to be an instance of "%s". "%s" given';
            $givenType = (is_object($file) ? get_class($file) : gettype($file));

            throw new \RuntimeException(sprintf($message, static::class, $method, \SplFileInfo::class, $givenType));
        }

        return true;
    }
}
