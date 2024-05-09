<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class SubscriptionIntervalCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "subscription_intervals";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new SubscriptionInterval($this->client);
    }
}