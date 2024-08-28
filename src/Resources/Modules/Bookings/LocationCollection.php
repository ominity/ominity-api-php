<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\PaginatedCollection;

class LocationCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "bookings_locations";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Location($this->client);
    }
}