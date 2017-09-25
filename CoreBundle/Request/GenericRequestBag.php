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
namespace Beotie\CoreBundle\Request;

/**
 * Generic request bag
 *
 * This class is used to manage the requests elements
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericRequestBag implements RequestBagInterface
{
    /**
     * Data
     *
     * This property store the request bag data
     *
     * @var mixed
     */
    private $data;

    /**
     * Construct
     *
     * The default GenericRequestBag constructor
     *
     * @param mixed $data The request data
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get data
     *
     * This method return the request data
     *
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }
}
