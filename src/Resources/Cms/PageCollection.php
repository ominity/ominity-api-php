<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\PaginatedCollection;

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