<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\PaginatedCollection;

class RouteCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "routes";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Route($this->client);
    }
}