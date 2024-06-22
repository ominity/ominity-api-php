<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\PaginatedCollection;

class MenuCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "menus";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Menu($this->client);
    }
}