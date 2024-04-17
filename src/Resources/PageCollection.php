<?php

namespace Ominity\Api\Resources;

class PageCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "pages";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Page($this->client);
    }
}