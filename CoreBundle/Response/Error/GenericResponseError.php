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
namespace Beotie\CoreBundle\Response\Error;

/**
 * Generic response error
 *
 * This class is used to manage a response error
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseError implements ResponseErrorInterface
{
    /**
     * Data
     *
     * This property store the data that lead error
     *
     * @var mixed
     */
    private $data;

    /**
     * Data part locator
     *
     * This property store the data part locator that indicate the precisely part of
     * the data that lead the error
     *
     * @var string
     */
    private $dataPartLocator = '';

    /**
     * Data value
     *
     * This property store the initial data value that lead the error
     *
     * @var mixed
     */
    private $dataValue;

    /**
     * Message
     *
     * This property store the error message
     *
     * @var string
     */
    private $message = '';

    /**
     * Error code
     *
     * This property store the error code
     *
     * @var string
     */
    private $errorCode = '';

    /**
     * Get data
     *
     * This method return the data that lead errors
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get data part locator
     *
     * This method return the data part locator that indicate which part of the data precisely
     * lead the error
     *
     * @return string
     */
    public function getDataPartLocator() : string
    {
        return $this->dataPartLocator;
    }

    /**
     * Get data value
     *
     * This method return the data value that lead errors
     *
     * @return mixed
     */
    public function getDataValue()
    {
        return $this->dataValue;
    }

    /**
     * Get message
     *
     * This method return the error message
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Get error code
     *
     * This method return the error code
     *
     * @return string
     */
    public function getErrorCode() : string
    {
        return $this->errorCode;
    }

    /**
     * Set data
     *
     * This method allow to set the data that lead the error
     *
     * @param mixed $data The data that lead error
     *
     * @return $this
     */
    public function setData($data) : ResponseErrorInterface
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set data part locator
     *
     * This method allow to define the data part locator, that indicate which part of the data
     * precisely lead the error
     *
     * @param string $locator The data part locator
     *
     * @return ResponseErrorInterface
     */
    public function setDataPartLocator(string $locator) : ResponseErrorInterface
    {
        $this->dataPartLocator = $locator;
        return $this;
    }

    /**
     * Set data value
     *
     * This method allow to set the data value that lead the error
     *
     * @param mixed $value The data value that lead error
     *
     * @return $this
     */
    public function setDataValue($value) : ResponseErrorInterface
    {
        $this->dataValue = $value;
        return $this;
    }

    /**
     * Set message
     *
     * This method set the error message
     *
     * @param string $message The error message
     *
     * @return ResponseErrorInterface
     */
    public function setMessage(string $message) : ResponseErrorInterface
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set error code
     *
     * This method set the error code
     *
     * @param string $code The error code
     *
     * @return ResponseErrorInterface
     */
    public function setErrorCode(string $code) : ResponseErrorInterface
    {
        $this->errorCode = $code;
        return $this;
    }
}
