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

use Beotie\CoreBundle\Response\Error\ResponseErrorBagInterface;
use Beotie\CoreBundle\Response\Error\GenericResponseErrorBag;

/**
 * Generic response error bag factory
 *
 * This class is used to create GenericResponseErrorBag instance
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorBagFactory implements ResponseErrorBagFactoryInterface
{
    /**
     * Get ResponseErrorBag
     *
     * This method return a new instance of ResponseErrorBag
     *
     * @return ResponseErrorBagInterface
     */
    public function getResponseErrorBag() : ResponseErrorBagInterface
    {
        return new GenericResponseErrorBag();
    }
}
