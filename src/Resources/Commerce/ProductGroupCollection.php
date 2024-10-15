<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class ProductGroupCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "product_groups";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Product($this->client);
    }
}