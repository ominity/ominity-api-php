<?php

namespace Ominity\Api\Resources;

class RouteCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "route";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Route($this->client);
    }
}