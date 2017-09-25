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
 * Response data interface
 *
 * This interface is used to define the data part base methods
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseDataInterface
{
    /**
     * Set data
     *
     * This method allow to set up the response data part
     *
     * @param mixed $data The data
     *
     * @return $this
     */
    public function setData($data) : ResponseDataInterface;

    /**
     * Set type
     *
     * This method allow to set up the ResponseData type
     *
     * @param string $type The type as string
     *
     * @return $this
     */
    public function setType(string $type) : ResponseDataInterface;

    /**
     * Set id
     *
     * This method allow to set up the ResponseData id
     *
     * @param mixed $id The id
     *
     * @return $this
     */
    public function setId($id) : ResponseDataInterface;

    /**
     * Set attributes
     *
     * This method allow to set up the ResponseData attributes
     *
     * @param array $attributes The attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes) : ResponseDataInterface;

    /**
     * Set relationships
     *
     * This method allow to set up the ResponseData relationships
     *
     * @param array $relationships The relationships
     *
     * @return $this
     */
    public function setRelationships(array $relationships) : ResponseDataInterface;

    /**
     * Set links
     *
     * This method allow to set up the ResponseData links
     *
     * @param array $links The links
     *
     * @return $this
     */
    public function setLinks(array $links) : ResponseDataInterface;

    /**
     * Get data
     *
     * This method return the response data part
     *
     * @return mixed
     */
    public function getData();

    /**
     * Get type
     *
     * This method return the response type part
     *
     * @return string
     */
    public function getType() : string;

    /**
     * Get id
     *
     * This method return the response id part
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get attributes
     *
     * This method return the response attributes part
     *
     * @return array
     */
    public function getAttributes() : array;

    /**
     * Get relationships
     *
     * This method return the response relationships part
     *
     * @return array
     */
    public function getRelationships() : array;

    /**
     * Get links
     *
     * This method return the response links part
     *
     * @return array
     */
    public function getLinks() : array;
}
