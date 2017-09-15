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
     * Parameters
     *
     * This property store the request parameters
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Options
     *
     * This property store the request options
     *
     * @var array
     */
    private $options = [];

    /**
     * Construct
     *
     * The default GenericRequestBag constructor
     *
     * @param array $parameters The request parameters
     * @param array $options    The request options
     *
     * @return void
     */
    public function __construct(array $parameters = [], array $options = [])
    {
        $this->addParameters($parameters);
        $this->addOptions($options);
    }

    /**
     * Get request params
     *
     * This method return the request parameters as array
     *
     * @return array
     */
    public function getRequestParams() : array
    {
        return $this->parameters;
    }

    /**
     * Has request parameter
     *
     * This method validate the existance of a parameter
     *
     * @param string $paramName The parameter name
     *
     * @return bool
     */
    public function hasRequestParam(string $paramName) : bool
    {
        return array_key_exists($paramName, $this->parameters);
    }

    /**
     * Get request parameter
     *
     * This method return an existing parameter by name, or null if it not exist
     *
     * @param string $paramName The parameter name
     *
     * @return mixed|null
     */
    public function getRequestParam(string $paramName)
    {
        if (!$this->hasRequestParam($paramName)) {
            return null;
        }

        return $this->parameters[$paramName];
    }

    /**
     * Get request options
     *
     * This method return the request options as array
     *
     * @return array
     */
    public function getRequestOptions() : array
    {
        return $this->options;
    }

    /**
     * Has request option
     *
     * This method validate the existance of a option
     *
     * @param string $optionName The option name
     *
     * @return bool
     */
    public function hasRequestOption(string $optionName) : bool
    {
        return array_key_exists($optionName, $this->options);
    }

    /**
     * Get request option
     *
     * This method return an existing option by name, or null if it not exist
     *
     * @param string $optionName The option name
     *
     * @return mixed|null
     */
    public function getRequestOption(string $optionName)
    {
        if (!$this->hasRequestOption($optionName)) {
            return null;
        }

        return $this->options[$optionName];
    }

    /**
     * Add parameters
     *
     * This method add a set of parameters to the parameter storage
     *
     * @param array $parameters The parameters to inject
     *
     * @return void
     */
    private function addParameters(array $parameters)
    {
        foreach ($parameters as $paramName => $paramValue) {
            $this->addParameter($paramName, $paramValue);
        }
    }

    /**
     * Add parameter
     *
     * This method inject a new parameter into the parameter storage
     *
     * @param string $parameterName  The parameter name
     * @param mixed  $parameterValue The parameter value
     *
     * @return void
     */
    private function addParameter(string $parameterName, $parameterValue)
    {
        $this->parameters[$parameterName] = $parameterValue;
    }

    /**
     * Add options
     *
     * This method add a set of options to the option storage
     *
     * @param array $options The options to inject
     *
     * @return void
     */
    private function addOptions(array $options)
    {
        foreach ($options as $optionName => $optionValue) {
            $this->addOption($optionName, $optionValue);
        }
    }

    /**
     * Add option
     *
     * This method inject a new option into the option storage
     *
     * @param string $optionName  The option name
     * @param mixed  $optionValue The option value
     *
     * @return void
     */
    private function addOption(string $optionName, $optionValue)
    {
        $this->options[$optionName] = $optionValue;
    }
}
