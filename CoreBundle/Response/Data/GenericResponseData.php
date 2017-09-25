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
 * Generic response data
 *
 * This class is used to store a response data part
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseData implements ResponseDataInterface
{
    /**
     * Data
     *
     * This property store the part data
     *
     * @var mixed
     */
    private $data;

    /**
     * Type
     *
     * This property store the data type
     *
     * @var string
     */
    private $type = '';

    /**
     * Id
     *
     * This property store the data id
     *
     * @var string
     */
    private $id;

    /**
     * Attributes
     *
     * This property store the data attributes
     *
     * @var array
     */
    private $attributes = [];

    /**
     * Relationships
     *
     * This property store the data relationships
     *
     * @var array
     */
    private $relationships = [];

    /**
     * Links
     *
     * This property store the data links
     *
     * @var array
     */
    private $links = [];

    /**
     * Set data
     *
     * This method allow to set up the response data part
     *
     * @param mixed $data The data
     *
     * @return ResponseDataInterface
     */
    public function setData($data) : ResponseDataInterface
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set type
     *
     * This method allow to set up the ResponseData type
     *
     * @param string $type The type as string
     *
     * @return $this
     */
    public function setType(string $type) : ResponseDataInterface
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set id
     *
     * This method allow to set up the ResponseData id
     *
     * @param mixed $id The id
     *
     * @return $this
     */
    public function setId($id) : ResponseDataInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set attributes
     *
     * This method allow to set up the ResponseData attributes
     *
     * @param array $attributes The attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes) : ResponseDataInterface
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Set relationships
     *
     * This method allow to set up the ResponseData relationships
     *
     * @param array $relationships The relationships
     *
     * @return $this
     */
    public function setRelationships(array $relationships) : ResponseDataInterface
    {
        $this->relationships = $relationships;
        return $this;
    }

    /**
     * Set links
     *
     * This method allow to set up the ResponseData links
     *
     * @param array $links The links
     *
     * @return $this
     */
    public function setLinks(array $links) : ResponseDataInterface
    {
        $this->links = $links;
        return $this;
    }

    /**
     * Get data
     *
     * This method return the response data part
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get type
     *
     * This method return the response type part
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Get id
     *
     * This method return the response id part
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get attributes
     *
     * This method return the response attributes part
     *
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * Get relationships
     *
     * This method return the response relationships part
     *
     * @return array
     */
    public function getRelationships() : array
    {
        return $this->relationships;
    }

    /**
     * Get links
     *
     * This method return the response links part
     *
     * @return array
     */
    public function getLinks() : array
    {
        return $this->links;
    }
}
