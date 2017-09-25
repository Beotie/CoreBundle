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
 * Generic data mediator resolver
 *
 * This class is used as generic DataMediatorResolver. It aim to manage a mediator storage
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDataMediatorResolver extends \SplObjectStorage implements DataMediatorResolverInterface
{
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
    public function getMediator($data) : ExternalDataMediatorInterface
    {
        foreach ($this as $mediator) {
            if ($this->mediatorSupport($mediator, $data)) {
                return $mediator;
            }
        }

        throw new \RuntimeException('No mediator found for given data');
    }

    /**
     * Add mediator
     *
     * This method allow to add a new external mediator to the internal mediator store
     *
     * @param ExternalDataMediatorInterface $mediator The mediator to add
     *
     * @return $this
     */
    public function addMediator(ExternalDataMediatorInterface $mediator) : DataMediatorResolverInterface
    {
        if (!$this->contains($mediator)) {
            $this->attach($mediator);
        }

        return $this;
    }

    /**
     * Has mediator
     *
     * This method indicate if the resolver currently contain a mediator which support the given data
     *
     * @param mixed $data The data that should be supported
     *
     * @return bool
     */
    public function hasMediator($data) : bool
    {
        foreach ($this as $mediator) {
            if ($this->mediatorSupport($mediator, $data)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mediator support
     *
     * This method return the mediator support state
     *
     * @param ExternalDataMediatorInterface $mediator The mediator
     * @param mixed                         $data     The data which should be supported
     *
     * @return bool
     */
    private function mediatorSupport(ExternalDataMediatorInterface $mediator, $data) : bool
    {
        return $mediator->support($data);
    }
}
