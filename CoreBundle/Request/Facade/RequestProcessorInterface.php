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
 * @category Request
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Beotie\CoreBundle\Request\Facade;

use Beotie\CoreBundle\Request\RequestBagInterface;
use Beotie\CoreBundle\Response\ResponseBagInterface;

/**
 * Request processor interface
 *
 * This interface is used to manage a request process
 *
 * @category Model
 * @package  Beotie_Core_Bundle
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequestProcessorInterface
{
    /**
     * Event getResources
     *
     * This constant is used as dispatch event name to process a multiple resource loading request
     *
     * @var string
     */
    const EVENT_GET_RESOURCES = 'event_get_resources';

    /**
     * Event getResource
     *
     * This constant is used as dispatch event name to process a resource loading request
     *
     * @var string
     */
    const EVENT_GET_RESOURCE = 'event_get_resource';

    /**
     * Event postResources
     *
     * This constant is used as dispatch event name to process a multiple resource creation request
     *
     * @var string
     */
    const EVENT_POST_RESOURCES = 'event_post_resources';

    /**
     * Event postResource
     *
     * This constant is used as dispatch event name to process a resource creation request
     *
     * @var string
     */
    const EVENT_POST_RESOURCE = 'event_post_resource';

    /**
     * Event putResource
     *
     * This constant is used as dispatch event name to process a resource replacement request
     *
     * @var string
     */
    const EVENT_PUT_RESOURCE = 'event_put_resource';

    /**
     * Event patchResource
     *
     * This constant is used as dispatch event name to process a resource partial modification request
     *
     * @var string
     */
    const EVENT_PATCH_RESOURCE = 'event_patch_resource';

    /**
     * Event deleteResource
     *
     * This constant is used as dispatch event name to process a resource deletion request
     *
     * @var string
     */
    const EVENT_DELETE_RESOURCE = 'event_delete_resource';

    /**
     * Get resources
     *
     * This method process a multiple resource loading request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function getResources(RequestBagInterface $request) : ResponseBagInterface;

    /**
     * Get resource
     *
     * This method process a resource loading request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function getResource(RequestBagInterface $request) : ResponseBagInterface;

    /**
     * Post resources
     *
     * This method process a multiple resource creation request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function postResources(RequestBagInterface $request) : ResponseBagInterface;

    /**
     * Post resource
     *
     * This method process a resource creation request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function postResource(RequestBagInterface $request) : ResponseBagInterface;

    /**
     * Put resources
     *
     * This method process a resource replacement request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function putResource(RequestBagInterface $request) : ResponseBagInterface;

    /**
     * Patch resources
     *
     * This method process a resource partial modification request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function patchResource(RequestBagInterface $request) : ResponseBagInterface;

    /**
     * Delete resources
     *
     * This method process a resource deletion request
     *
     * @param RequestBagInterface $request The base request
     *
     * @return ResponseBagInterface
     */
    public function deleteResource(RequestBagInterface $request) : ResponseBagInterface;
}
