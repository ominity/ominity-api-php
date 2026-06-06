<?php

namespace Ominity\Api\Endpoints\Tracking;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class TrackingEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * Tracking event resource.
     *
     * @var TrackingEventEndpoint
     */
    public $events;

    public function initializeEndpoints()
    {
        $this->events = new TrackingEventEndpoint($this->client);
    }
}
