<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class CategoryCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "categories";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Category($this->client);
    }
}