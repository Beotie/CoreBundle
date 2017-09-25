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
namespace Beotie\CoreBundle\Request\Event;

use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;
use Beotie\CoreBundle\Event\EventInterface;

/**
 * Request event interface
 *
 * This interface define the base event methods
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestEventInterface extends EventInterface
{
    /**
     * Get request
     *
     * This method return the base request
     *
     * @return RequestBagInterface
     */
    public function getRequest() : RequestBagInterface;

    /**
     * Get response
     *
     * This method return the process response
     *
     * @return ResponseBagInterface
     */
    public function getResponse() : ResponseBagInterface;
}
