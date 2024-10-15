<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class ShippingZoneCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "shipping_zones";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new ShippingZone($this->client);
    }
}