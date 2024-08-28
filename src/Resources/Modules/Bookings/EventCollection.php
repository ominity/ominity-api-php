<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\PaginatedCollection;

class EventCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "bookings_events";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Event($this->client);
    }
}