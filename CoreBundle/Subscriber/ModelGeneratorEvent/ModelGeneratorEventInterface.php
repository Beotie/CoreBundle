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
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Subscriber\ModelGeneratorEvent;

use Beotie\CoreBundle\Event\EventInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Model generator event interface
 *
 * This interface define the base event methods
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ModelGeneratorEventInterface extends EventInterface
{
    /**
     * Set data transfert object
     *
     * This method allow to set up the data transfert object
     *
     * @param object $dataTransfertObject The data transfert object
     *
     * @return $this
     */
    public function setDataTransfertObject($dataTransfertObject) : ModelGeneratorEventInterface;

    /**
     * Get data transfert object
     *
     * This method return the data transfert object
     *
     * @return object
     */
    public function getDataTransfertObject();

    /**
     * Set model
     *
     * This method allow to setup the result model
     *
     * @param object $model The process resulting model
     *
     * @return ModelGeneratorEventInterface
     */
    public function setModel($model) : ModelGeneratorEventInterface;

    /**
     * Get model
     *
     * This method return the process resulting model
     *
     * @return object
     */
    public function getModel();

    /**
     * Get response
     *
     * This method return the process response
     *
     * @return ResponseBagInterface
     */
    public function getResponse() : ResponseBagInterface;
}
