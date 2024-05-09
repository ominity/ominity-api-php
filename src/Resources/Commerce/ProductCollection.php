<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class ProductCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "products";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Product($this->client);
    }
}