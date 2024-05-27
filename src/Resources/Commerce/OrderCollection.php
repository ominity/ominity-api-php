<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class OrderCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "orders";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Order($this->client);
    }
}