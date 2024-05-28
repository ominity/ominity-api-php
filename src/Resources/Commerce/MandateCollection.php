<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class MandateCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "mandates";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Mandate($this->client);
    }
}