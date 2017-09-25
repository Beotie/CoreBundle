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
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Model\Factory;

use Beotie\CoreBundle\Model\DataTransfertObject\Exception\UnvalidatedDto;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Model factory interface
 *
 * This interface define the base ModelFactories methods
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ModelFactoryInterface
{
    /**
     * Build model
     *
     * This method build a new model instance and return it
     *
     * @param object $dataTransferObject The model DTO to build model from
     *
     * @return object
     * @throws UnvalidatedDto
     */
    public function buildModel($dataTransferObject);

    /**
     * Is valid
     *
     * This method validate a RoleDTO before building a Role instance
     *
     * @param object $dataTransferObject The DTO to validate
     *
     * @return bool
     */
    public function isValid($dataTransferObject) : bool;

    /**
     * Get validation errors
     *
     * This method return the validations errors a constraint violation list
     *
     * @param object $dataTransferObject The invalid DTO
     *
     * @return ConstraintViolationListInterface
     */
    public function getValidationErrors($dataTransferObject) : ConstraintViolationListInterface;
}
