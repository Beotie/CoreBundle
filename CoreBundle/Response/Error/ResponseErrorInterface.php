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
 * Response error interface
 *
 * This interface is used to manage a response error
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseErrorInterface
{
    /**
     * Set data
     *
     * This method allow to set the data that lead the error
     *
     * @param mixed $data The data that lead error
     *
     * @return $this
     */
    public function setData($data) : ResponseErrorInterface;

    /**
     * Get data
     *
     * This method return the data that lead errors
     *
     * @return mixed
     */
    public function getData();

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
    public function setDataPartLocator(string $locator) : ResponseErrorInterface;

    /**
     * Get data part locator
     *
     * This method return the data part locator that indicate which part of the data precisely
     * lead the error
     *
     * @return string
     */
    public function getDataPartLocator() : string;

    /**
     * Set data value
     *
     * This method allow to set the data value that lead the error
     *
     * @param mixed $value The data value that lead error
     *
     * @return $this
     */
    public function setDataValue($value) : ResponseErrorInterface;

    /**
     * Get data value
     *
     * This method return the data value that lead errors
     *
     * @return mixed
     */
    public function getDataValue();

    /**
     * Set message
     *
     * This method set the error message
     *
     * @param string $message The error message
     *
     * @return ResponseErrorInterface
     */
    public function setMessage(string $message) : ResponseErrorInterface;

    /**
     * Get message
     *
     * This method return the error message
     *
     * @return string
     */
    public function getMessage() : string;

    /**
     * Set error code
     *
     * This method set the error code
     *
     * @param string $code The error code
     *
     * @return ResponseErrorInterface
     */
    public function setErrorCode(string $code) : ResponseErrorInterface;

    /**
     * Get error code
     *
     * This method return the error code
     *
     * @return string
     */
    public function getErrorCode() : string;
}
