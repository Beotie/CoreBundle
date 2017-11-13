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
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Stream\Factory;

use Psr\Http\Message\StreamInterface;

/**
 * Stream factory interface
 *
 * This interface define the base StreamFactory methods
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface StreamFactoryInterface
{
    /**
     * Get stream
     *
     * This method return a stream instance. The optional params parameter can be used to provide constructor or
     * setter arguments during the instanciation.
     *
     * @param array $params [optional] the instanciation parameters
     *
     * @return StreamInterface
     */
    public function getStream(array $params = []) : StreamInterface;
}
