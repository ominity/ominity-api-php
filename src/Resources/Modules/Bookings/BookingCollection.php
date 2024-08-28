<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\PaginatedCollection;

class BookingCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "bookings";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Booking($this->client);
    }
}