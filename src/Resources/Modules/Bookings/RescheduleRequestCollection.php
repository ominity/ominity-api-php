<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\PaginatedCollection;

class RescheduleRequestCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "bookings_reschedule_requests";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new RescheduleRequest($this->client);
    }
}