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
 * Request bag interface
 *
 * This interface is used to manage the requests elements
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestBagInterface
{
    /**
     * Get request params
     *
     * This method return the request parameters as array
     *
     * @return array
     */
    public function getRequestParams() : array;

    /**
     * Has request parameter
     *
     * This method validate the existance of a parameter
     *
     * @param string $paramName The parameter name
     *
     * @return bool
     */
    public function hasRequestParam(string $paramName) : bool;

    /**
     * Get request parameter
     *
     * This method return an existing parameter by name, or null if it not exist
     *
     * @param string $paramName The parameter name
     *
     * @return mixed|null
     */
    public function getRequestParam(string $paramName);

    /**
     * Get request options
     *
     * This method return the request options as array
     *
     * @return array
     */
    public function getRequestOptions() : array;

    /**
     * Has request option
     *
     * This method validate the existance of a option
     *
     * @param string $optionName The option name
     *
     * @return bool
     */
    public function hasRequestOption(string $optionName) : bool;

    /**
     * Get request option
     *
     * This method return an existing option by name, or null if it not exist
     *
     * @param string $optionName The option name
     *
     * @return mixed|null
     */
    public function getRequestOption(string $optionName);
}
