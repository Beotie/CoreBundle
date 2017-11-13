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
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Request\File\Factory;

use Psr\Http\Message\UploadedFileInterface;
use Beotie\CoreBundle\Request\File\RequestUploadedFileAdapter;

/**
 * Request uploaded file factory
 *
 * This class is used to build an instance of RequestUploadedFileAdapter.
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RequestUploadedFileFactory implements EmbeddedFileFactoryInterface
{
    /**
     * Array key
     *
     * This constant define the array key name where is store the embedded content instance
     *
     * @var string
     */
    protected const ARRAY_KEY = 'inner_content';

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
     * Get upload file
     *
     * This method return an instance of UploadFileInterface
     *
     * @param array $params [required] the instanciation parameters
     *
     * @throws \RuntimeException If the given parameters does not have a 'inner_content' key
     * @throws \RuntimeException If the given content does not match the expected UploadedFile type
     * @return UploadedFileInterface
     */
    public function getUploadFile(array $params = []) : UploadedFileInterface
    {
        if ($this->paramHasContent($params) && $this->contentIsUploadedFile($params[self::ARRAY_KEY])) {
            return new RequestUploadedFileAdapter($params[self::ARRAY_KEY]);
        }
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
    protected function paramHasContent(array $params, string $method = 'getUploadFile') : bool
    {
        if (!array_key_exists(self::ARRAY_KEY, $params)) {
            throw new \RuntimeException(
                sprintf(
                    'The "%s::%s" expect a file array key to build an instance of RequestUploadedFileAdapter',
                    static::class,
                    $method
                )
            );
        }

        return true;
    }

    /**
     * Content is UploadedFile
     *
     * This method validate the instance of the given content parameter. This type is expected to be UplloadedFile.
     *
     * @param mixed  $file   The file which the method aim to validate the type
     * @param string $method The original method name. This parameter is used to define the exception message
     *
     * @throws \RuntimeException If the given content does not match the expected type
     * @return bool
     */
    protected function contentIsUploadedFile($file, string $method = 'getStream') : bool
    {
        if (! $file instanceof UploadedFileInterface) {
            throw new \RuntimeException(
                sprintf(
                    'The "%s::%s" expect the file array key to be an instance of "%s". "%s" given',
                    static::class,
                    $method,
                    UploadedFileInterface::class,
                    (is_object($file) ? get_class($file) : gettype($file))
                )
            );
        }

        return true;
    }
}
