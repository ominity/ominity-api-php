<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\PaginatedCollection;

class EventOccurenceCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "bookings_event_occurrences";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new EventOccurrence($this->client);
    }
}