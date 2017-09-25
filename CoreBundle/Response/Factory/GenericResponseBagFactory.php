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
namespace Beotie\CoreBundle\Response\Factory;

use Beotie\CoreBundle\Response\GenericResponseBag;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Generic response bag factory
 *
 * This class is used to create GenericResponseBag instance
 *
 * @category Response
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericResponseBagFactory implements ResponseBagFactoryInterface
{
    /**
     * Error bag factory
     *
     * This property store the ResponseErrorBagFactory instance to create a new ResponseErrorBag to be injected
     * into the GenericResponseBag.
     *
     * @var ResponseErrorBagFactoryInterface
     */
    private $errorBagFactory;

    /**
     * Data bag factory
     *
     * This property store the ResponseDataBagFactory instance to create a new ResponseDataBag to be injected
     * into the GenericResponseBag
     *
     * @var ResponseDataBagFactoryInterface
     */
    private $dataBagFactory;

    /**
     * Construct
     *
     * The default GenericResponseBagFactory constructor
     *
     * @param ResponseErrorBagFactoryInterface $errorBagFactory The error bag factory
     * @param ResponseDataBagFactoryInterface  $dataBagFactory  The data bag factory
     *
     * @return void
     */
    public function __construct(
        ResponseErrorBagFactoryInterface $errorBagFactory,
        ResponseDataBagFactoryInterface $dataBagFactory
    ) {
        $this->errorBagFactory = $errorBagFactory;
        $this->dataBagFactory = $dataBagFactory;
    }

    /**
     * Get ResponseBag
     *
     * This method return a new instance of ResponseBag
     *
     * @return ResponseBagInterface
     */
    public function getResponseBag() : ResponseBagInterface
    {
        return new GenericResponseBag(
            $this->errorBagFactory->getResponseErrorBag(),
            $this->dataBagFactory->getResponseDataBag()
        );
    }
}
