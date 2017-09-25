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
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Response\Error;

/**
 * Generic response error bag
 *
 * This class is used to manage the response errors
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseErrorBag extends \SplQueue implements ResponseErrorBagInterface
{
    /**
     * Add error part
     *
     * This method add a new error part to the response bag
     *
     * @param ResponseErrorInterface $errorPart The error part to add
     *
     * @return $this
     */
    public function addErrorPart(ResponseErrorInterface $errorPart) : ResponseErrorBagInterface
    {
        $this->push($errorPart);
        return $this;
    }

    /**
     * Count error parts
     *
     * This method return the error parts count of the response bag
     *
     * @return int
     */
    public function countErrorParts() : int
    {
        return $this->count();
    }

    /**
     * Get error part
     *
     * This method return an error part at the given offset
     *
     * @param int $offset The error part offset
     *
     * @return ResponseErrorBagInterface|null
     */
    public function getErrorPart(int $offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->offsetGet($offset);
        }

        return null;
    }

    /**
     * Set error part
     *
     * This method allow to set an error part at a specified offset
     *
     * @param int                    $offset    The error part offset
     * @param ResponseErrorInterface $errorPart The error part to store
     *
     * @return $this
     */
    public function setErrorPart(int $offset, ResponseErrorInterface $errorPart) : ResponseErrorBagInterface
    {
        $this->offsetSet($offset, $errorPart);
        return $this;
    }

    /**
     * Get error parts
     *
     * This method return the response bag set of error parts
     *
     * @return array
     */
    public function getErrorParts() : array
    {
        return iterator_to_array($this);
    }

    /**
     * Set error parts
     *
     * This method allow to set up the error part storage. It flush error parts before insert new
     *
     * @param array $errorParts The error parts to add
     *
     * @return $this
     */
    public function setErrorParts(array $errorParts) : ResponseErrorBagInterface
    {
        $this->flushErrorParts();
        foreach ($errorParts as $errorPart) {
            $this->addErrorPart($errorPart);
        }

        return $this;
    }

    /**
     * Flush error parts
     *
     * This method flush the response errors
     *
     * @return array
     */
    public function flushErrorParts() : array
    {
        $errors = [];
        while ($this->count() > 0) {
            $errors[] = $this->shift();
        }

        return $errors;
    }
}
