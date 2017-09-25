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
namespace Beotie\CoreBundle\Model\Mediator\Resolver;

use Beotie\CoreBundle\Model\Mediator\ExternalDataMediatorInterface;

/**
 * Data mediator resolver interface
 *
 * This interface is used to define the methods of the data mediator resolver, used to resolve an external data
 * mediator, regarding the given data
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DataMediatorResolverInterface
{
    /**
     * Add mediator
     *
     * This method allow to add a new external mediator to the internal mediator store
     *
     * @param ExternalDataMediatorInterface $mediator The mediator to add
     *
     * @return $this
     */
    public function addMediator(ExternalDataMediatorInterface $mediator) : DataMediatorResolverInterface;

    /**
     * Has mediator
     *
     * This method indicate if the resolver currently contain a mediator which support the given data
     *
     * @param mixed $data The data that should be supported
     *
     * @return bool
     */
    public function hasMediator($data) : bool;

    /**
     * Get mediator
     *
     * This method return the external mediator that support the given data
     *
     * @param mixed $data The data that should be supported
     *
     * @return ExternalDataMediatorInterface
     * @throws \RuntimeException
     */
    public function getMediator($data) : ExternalDataMediatorInterface;
}
