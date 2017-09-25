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
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Response\Factory;

use Beotie\CoreBundle\Response\Data\ResponseDataInterface;

/**
 * Response data factory interface
 *
 * This interface define the base ResponseDataFactory methods
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseDataFactoryInterface
{
    /**
     * Get response data
     *
     * This method create and return a new instance of ResponseData
     *
     * @return ResponseDataInterface
     */
    public function getResponseData() : ResponseDataInterface;

    /**
     * Create from data
     *
     * This method create a ResponseData based on a given data
     *
     * @param mixed $data The ResponseData data
     *
     * @return ResponseDataInterface
     * @throws \RuntimeException
     */
    public function createFromData($data) : ResponseDataInterface;
}
