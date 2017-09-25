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

use Symfony\Component\EventDispatcher\Event;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Model generator event
 *
 * This class is used for the model generation process as initiator event
 *
 * @category Subscriber
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ModelGeneratorEvent extends Event implements ModelGeneratorEventInterface
{
    /**
     * Data transfert object
     *
     * This property store the model data transfert object
     *
     * @var object
     */
    private $dataTransfertObject;

    /**
     * Model
     *
     * This property store the process resulting model
     *
     * @var object
     */
    private $model;

    /**
     * Response
     *
     * This method return the process response
     *
     * @var ResponseBagInterface
     */
    private $response;

    /**
     * Construct
     *
     * The default ModelGeneratorEvent constructor
     *
     * @param object               $dataTransfertObject The base data transfert object
     * @param ResponseBagInterface $response            The original response bag
     *
     * @return void
     */
    public function __construct($dataTransfertObject, ResponseBagInterface $response)
    {
        $this->dataTransfertObject = $dataTransfertObject;
        $this->response = $response;
    }

    /**
     * Get model
     *
     * This method return the process resulting model
     *
     * @return object
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get data transfert object
     *
     * This method return the data transfert object
     *
     * @return object
     */
    public function getDataTransfertObject()
    {
        return $this->dataTransfertObject;
    }

    /**
     * Set model
     *
     * This method allow to setup the result model
     *
     * @param object $model The process resulting model
     *
     * @return ModelGeneratorEventInterface
     */
    public function setModel($model) : ModelGeneratorEventInterface
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Set data transfert object
     *
     * This method allow to set up the data transfert object
     *
     * @param object $dataTransfertObject The data transfert object
     *
     * @return $this
     */
    public function setDataTransfertObject($dataTransfertObject) : ModelGeneratorEventInterface
    {
        $this->dataTransfertObject = $dataTransfertObject;
        return $this;
    }

    /**
     * Get response
     *
     * This method return the process response
     *
     * @return ResponseBagInterface
     */
    public function getResponse() : ResponseBagInterface
    {
        return $this->response;
    }
}
