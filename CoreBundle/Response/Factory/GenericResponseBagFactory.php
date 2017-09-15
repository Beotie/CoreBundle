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
namespace Beotie\CoreBundle\Response\Factory;

use Beotie\CoreBundle\Response\GenericResponseBag;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Generic response bag factory
 *
 * This class is used to create GenericResponseBag instance
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseBagFactory implements ResponseBagFactoryInterface
{
    /**
     * Get ResponseBag
     *
     * This method return a new instance of ResponseBag
     *
     * @return ResponseBagInterface
     */
    public function getResponseBag() : ResponseBagInterface
    {
        return new GenericResponseBag();
    }
}
