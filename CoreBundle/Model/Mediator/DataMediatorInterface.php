<?php
declare(strict_types=1);
/**
 * This file is part of beotie/user_bundle
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.1
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Model\Mediator;

/**
 * Data mediator interface
 *
 * This interface is used to define the methods of the data mediator
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DataMediatorInterface
{
    /**
     * Get data type
     *
     * This method return the data type as string
     *
     * @param mixed $data The data whence get type
     *
     * @return string
     */
    public function getDataType($data) : string;

    /**
     * Get data id
     *
     * This method return the data id
     *
     * @param mixed $data The data whence get id
     *
     * @return mixed
     */
    public function getDataId($data);

    /**
     * Get data attribute
     *
     * This method return the array representation of the data attributes
     *
     * @param mixed $data The data whence get attributes
     *
     * @return array
     */
    public function getDataAttrbutes($data) : array;

    /**
     * Get data relationships
     *
     * This method return the array representation of the data relationships
     *
     * @param mixed $data The data whence get relationships
     *
     * @return array
     */
    public function getDataRelationships($data) : array;

    /**
     * Get data links
     *
     * This method return the array representation of the data links
     *
     * @param mixed $data The data whence get links
     *
     * @return array
     */
    public function getDataLinks($data) : array;
}
