<?php
declare(strict_types=1);
/**
 * This file is part of beotie/user_bundle
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
namespace Beotie\CoreBundle\Model\Mediator;

/**
 * External data mediator interface
 *
 * This interface is used to define the methods of the external data mediator, used to describe a data
 * within another instance
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ExternalDataMediatorInterface extends DataMediatorInterface
{
    /**
     * Support
     *
     * This method return the support state of the ExternalDataMediator, according with the given data
     *
     * @param mixed $data The data which the mediator should support
     *
     * @return bool
     */
    public function support($data) : bool;
}
