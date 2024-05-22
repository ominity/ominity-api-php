<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class PaymentCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "payments";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Payment($this->client);
    }
}