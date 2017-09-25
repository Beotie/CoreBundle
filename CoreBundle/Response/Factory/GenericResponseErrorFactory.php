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

use Beotie\CoreBundle\Response\Error\GenericResponseError;
use Beotie\CoreBundle\Response\Error\ResponseErrorInterface;

/**
 * Response error factory
 *
 * This class is used to create ResponseError instances
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorFactory implements ResponseErrorFactoryInterface
{
    /**
     * Get response error
     *
     * This method create and return a response error instance
     *
     * @return ResponseErrorInterface
     */
    public function getResponseError() : ResponseErrorInterface
    {
        return new GenericResponseError();
    }
}
