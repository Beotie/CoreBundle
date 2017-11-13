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

/**
 * Upload file factory interface
 *
 * This interface define the base UploadFileFactory methods
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface UploadFileFactoryInterface
{
    /**
     * Get upload file
     *
     * This method return an instance of UploadFileInterface
     *
     * @param array $params [optional] The factory parameters
     *
     * @return UploadedFileInterface
     */
    public function getUploadFile(array $params = []) : UploadedFileInterface;
}
