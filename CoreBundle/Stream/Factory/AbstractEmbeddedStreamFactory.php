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

/**
 * Abstract embedded stream factory
 *
 * This class is used to build a StreamInterface instance with embedded content
 *
 * @category Stream
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractEmbeddedStreamFactory implements EmbeddedStreamFactoryInterface
{
    /**
     * Array key
     *
     * This constant define the array key name where is store the embedded content instance
     *
     * @var string
     */
    protected const ARRAY_KEY = 'inner_content';

    /**
     * Get array key
     *
     * This method return the expected array key to retreive the embedded content
     *
     * @return string
     */
    public static function getArrayKey() : string
    {
        return self::ARRAY_KEY;
    }
}
