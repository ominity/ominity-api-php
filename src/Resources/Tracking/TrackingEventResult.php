<?php

namespace Ominity\Api\Resources\Tracking;

use Ominity\Api\Resources\BaseResource;

class TrackingEventResult extends BaseResource
{
    /**
     * Indicates whether the event was accepted.
     *
     * @var bool
     */
    public $success;

    /**
     * UUID visitor identifier associated with the tracked event.
     *
     * @var string
     */
    public $visitorId;
}
