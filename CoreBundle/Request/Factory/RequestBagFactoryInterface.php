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
namespace Beotie\CoreBundle\Request\Factory;

use Beotie\CoreBundle\Request\RequestBagInterface;

/**
 * Request bag factory interface
 *
 * This interface define the base RequestBagFactory methods
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestBagFactoryInterface
{
    /**
     * Get request bag
     *
     * This method return a request bag
     *
     * @return RequestBagInterface
     */
    public function getRequestBag() : RequestBagInterface;
}
