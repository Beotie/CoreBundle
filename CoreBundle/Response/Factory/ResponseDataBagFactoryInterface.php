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

use Beotie\CoreBundle\Response\Data\ResponseDataBagInterface;

/**
 * Response data bag factory
 *
 * This interface is used to define the base ResponseDataBagFactory methods
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseDataBagFactoryInterface
{
    /**
     * Get ResponseDataBag
     *
     * This method create and return a new instance of ResponseDataBag
     *
     * @return ResponseDataBagInterface
     */
    public function getResponseDataBag() : ResponseDataBagInterface;
}
