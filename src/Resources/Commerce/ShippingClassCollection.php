<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class ShippingClassCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "shipping_classes";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new ShippingClass($this->client);
    }
}