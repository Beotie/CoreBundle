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
namespace Beotie\CoreBundle\Request\Event\Factory;

use Beotie\CoreBundle\Request\Event\RequestEventInterface;
use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Request event factory interface
 *
 * This interface define the base RequestEventFactory methods
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestEventFactoryInterface
{
    /**
     * Get request event
     *
     * This method return a new instance of RequestEvent
     *
     * @param RequestBagInterface  $request  The event request
     * @param ResponseBagInterface $response The event response
     *
     * @return RequestEventInterface
     */
    public function getRequestEvent(
        RequestBagInterface $request,
        ResponseBagInterface $response
    ) : RequestEventInterface;
}
