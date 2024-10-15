<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class ReviewCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "reviews";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Review($this->client);
    }
}