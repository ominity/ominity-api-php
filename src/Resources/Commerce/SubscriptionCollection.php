<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class SubscriptionCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "subscriptions";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Subscription($this->client);
    }
}