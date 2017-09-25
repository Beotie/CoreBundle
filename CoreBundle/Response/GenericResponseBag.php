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
namespace Beotie\CoreBundle\Response;

use Beotie\CoreBundle\Response\Error\ResponseErrorBagInterface;
use Beotie\CoreBundle\Response\Data\ResponseDataBagInterface;

/**
 * Generic response bag
 *
 * This class is used as container for a process response
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseBag implements ResponseBagInterface
{
    /**
     * Error bag
     *
     * This property store the response error bag
     *
     * @var ResponseErrorBagInterface
     */
    private $errorBag;

    /**
     * Data bag
     *
     * This property store the response data bag
     *
     * @var ResponseDataBagInterface
     */
    private $dataBag;

    /**
     * Construct
     *
     * The default GenericResponseBag constructor
     *
     * @param ResponseErrorBagInterface $errorBag The response error bag
     * @param ResponseDataBagInterface  $dataBag  The response data bag
     *
     * @return void
     */
    public function __construct(ResponseErrorBagInterface $errorBag, ResponseDataBagInterface $dataBag)
    {
        $this->errorBag = $errorBag;
        $this->dataBag = $dataBag;
    }

    /**
     * Get error bag
     *
     * This method return the error bag of the response bag
     *
     * @return ResponseErrorBagInterface
     */
    public function getErrorBag() : ResponseErrorBagInterface
    {
        return $this->errorBag;
    }

    /**
     * Get data bag
     *
     * This method return the data bag of the response bag
     *
     * @return ResponseDataBagInterface
     */
    public function getDataBag() : ResponseDataBagInterface
    {
        return $this->dataBag;
    }
}
