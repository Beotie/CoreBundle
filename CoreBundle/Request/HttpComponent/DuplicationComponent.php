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
namespace Beotie\CoreBundle\Request\HttpComponent;

use Beotie\CoreBundle\Request\HttpRequestServerAdapter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Duplication component
 *
 * This trait is used to duplicate symfony Request instance
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait DuplicationComponent
{
    /**
     * Http request
     *
     * The base symfony http request
     *
     * @var Request
     */
    private $httpRequest;

    /**
     * Duplicate
     *
     * This method duplicate the current inner request and override the specified parameters
     *
     * @param array $param The parameters to override
     *
     * @return HttpRequestServerAdapter
     */
    protected function duplicate(array $param = []) : HttpRequestServerAdapter
    {
        $query = null;
        $request = null;
        $attributes = null;
        $cookies = null;
        $files = null;
        $server = null;

        $parameters = ['query', 'request', 'attributes', 'cookies', 'files', 'server'];

        foreach ($parameters as $parameter) {
            $$parameter = $this->httpRequest->{$parameter}->all();

            if (isset($param[$parameter])) {
                array_replace($$parameter, $param[$parameter]);
            }
        }

        $request = $this->httpRequest->duplicate($query, $request, $attributes, $cookies, $files, $server);

        return new static($request);
    }
}
