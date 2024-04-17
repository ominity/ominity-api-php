<?php

namespace Ominity\Api\Resources;

class ComponentCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "components";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Component($this->client);
    }
}