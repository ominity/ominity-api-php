<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class CustomerUserCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "customer_users";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new CustomerUser($this->client);
    }
}