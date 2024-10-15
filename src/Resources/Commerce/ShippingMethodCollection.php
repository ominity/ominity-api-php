<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class ShippingMethodCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "shipping_methods";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new ShippingMethod($this->client);
    }
}