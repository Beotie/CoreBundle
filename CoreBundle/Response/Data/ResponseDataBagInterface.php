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
namespace Beotie\CoreBundle\Response\Data;

/**
 * Response data bag interface
 *
 * This interface is used to manage the response data parts
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseDataBagInterface
{
    /**
     * Add data part
     *
     * This method add a new data part to the response bag
     *
     * @param ResponseDataInterface $dataPart The data part to add
     *
     * @return $this
     */
    public function addDataPart(ResponseDataInterface $dataPart) : ResponseDataBagInterface;

    /**
     * Count data parts
     *
     * This method return the data parts count of the response bag
     *
     * @return int
     */
    public function countDataParts() : int;

    /**
     * Get data part
     *
     * This method return an data part at the given offset
     *
     * @param int $offset The data part offset
     *
     * @return ResponseDataBagInterface|null
     */
    public function getDataPart(int $offset);

    /**
     * Set data part
     *
     * This method allow to set a data part at a specified offset
     *
     * @param int                   $offset   The data part offset
     * @param ResponseDataInterface $dataPart The data part to store
     *
     * @return $this
     */
    public function setDataPart(int $offset, ResponseDataInterface $dataPart) : ResponseDataBagInterface;

    /**
     * Get data parts
     *
     * This method return the response bag set of data parts
     *
     * @return array
     */
    public function getDataParts() : array;

    /**
     * Set data parts
     *
     * This method allow to set up the data part storage. It flush data parts before insert new
     *
     * @param array $dataParts The data parts to add
     *
     * @return $this
     */
    public function setDataParts(array $dataParts) : ResponseDataBagInterface;

    /**
     * Flush data parts
     *
     * This method flush the response data
     *
     * @return array
     */
    public function flushDataParts() : array;
}
