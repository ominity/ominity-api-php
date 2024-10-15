<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class CartCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "carts";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Cart($this->client);
    }
}