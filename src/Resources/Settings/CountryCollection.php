<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\PaginatedCollection;

class CountryCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "countries";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Country($this->client);
    }
}