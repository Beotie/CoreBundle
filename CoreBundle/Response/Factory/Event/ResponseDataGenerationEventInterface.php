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
namespace Beotie\CoreBundle\Response\Factory\Event;

use Beotie\CoreBundle\Event\EventInterface;
use Beotie\CoreBundle\Response\Data\ResponseDataInterface;

/**
 * Response data generation event interface
 *
 * This interface is used to define the base ResponseDataGenerationEvent methods
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseDataGenerationEventInterface extends EventInterface
{
    /**
     * Set data
     *
     * This method allow to set the base data element
     *
     * @param mixed $data The base data
     *
     * @return ResponseDataGenerationEventInterface
     */
    public function setData($data) : ResponseDataGenerationEventInterface;

    /**
     * Get data
     *
     * This method return the base data
     *
     * @return mixed
     */
    public function getData();

    /**
     * Set ResponseData
     *
     * This method allow to set up the ResponseData element. It stop the propagation
     *
     * @param ResponseDataInterface $responseData The ResponseData element
     *
     * @return ResponseDataGenerationEventInterface
     */
    public function setResponseData(ResponseDataInterface $responseData) : ResponseDataGenerationEventInterface;

    /**
     * Get ResponseData
     *
     * This method return the ResponseData element
     *
     * @return ResponseDataInterface
     */
    public function getResponseData() : ResponseDataInterface;
}
