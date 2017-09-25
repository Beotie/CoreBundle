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
 * Response bag interface
 *
 * This interface is used to manage a response
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseBagInterface
{
    /**
     * Get error bag
     *
     * This method return the error bag of the response bag
     *
     * @return ResponseErrorBagInterface
     */
    public function getErrorBag() : ResponseErrorBagInterface;

    /**
     * Get data bag
     *
     * This method return the data bag of the response bag
     *
     * @return ResponseDataBagInterface
     */
    public function getDataBag() : ResponseDataBagInterface;
}
