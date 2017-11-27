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
namespace Beotie\CoreBundle\Request\Builder;

use Beotie\CoreBundle\Request\RequestBagInterface;

/**
 * Request bag builder interface
 *
 * This interface define the base RequestBagBuilder methods
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestBagBuilderInterface
{
    /**
     * Set data
     *
     * This method set up the RequestBag data
     *
     * @param mixed $data The request data
     *
     * @return RequestBagBuilderInterface
     */
    public function setData($data) : RequestBagBuilderInterface;

    /**
     * Get data
     *
     * This method return the request data
     *
     * @return mixed
     */
    public function getData();

    /**
     * Get request bag
     *
     * This method return the builded RequestBag instance
     *
     * @return RequestBagInterface
     */
    public function getRequestBag() : RequestBagInterface;
}