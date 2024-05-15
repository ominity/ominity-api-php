<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class CustomerCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "customers";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Customer($this->client);
    }
}