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

use Beotie\CoreBundle\Request\Builder\RequestBagBuilderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Beotie\CoreBundle\Event\EventInterface;

/**
 * Request bag generation event
 *
 * This interface define the base RequestBagGenerationEvent methods
 *
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestBagGenerationEventInterface extends EventInterface
{
    /**
     * Get server request
     *
     * This method return the original server request
     *
     * @return ServerRequestInterface
     */
    public function getServerRequest() : ServerRequestInterface;

    /**
     * Get request bag builder
     *
     * This method return the current request bag builder
     *
     * @return RequestBagBuilderInterface
     */
    public function getRequestBagBuilder() : RequestBagBuilderInterface;
}
