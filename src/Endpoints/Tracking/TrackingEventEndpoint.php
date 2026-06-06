<?php

namespace Ominity\Api\Endpoints\Tracking;

use Ominity\Api\Endpoints\EndpointAbstract;
use Ominity\Api\Resources\Tracking\TrackingEventResult;

class TrackingEventEndpoint extends EndpointAbstract
{
    protected $resourcePath = "tracking/events";

    /**
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new TrackingEventResult($this->client);
    }

    /**
     * Track a visitor event.
     *
     * Expected fields match the public Ominity tracking contract, including
     * event, timestamp, visitorId, userId, url, metadata, referrer and utm.
     *
     * @param array $data
     * @param array $filters
     * @return TrackingEventResult
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function create(array $data, array $filters = [])
    {
        return parent::rest_create($data, $filters);
    }

    /**
     * Track a visitor event.
     *
     * @param array $data
     * @param array $filters
     * @return TrackingEventResult
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function track(array $data, array $filters = [])
    {
        return $this->create($data, $filters);
    }
}
