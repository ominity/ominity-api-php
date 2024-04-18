<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\PaginatedCollection;

class LayoutCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "layouts";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Layout($this->client);
    }
}