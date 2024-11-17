<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\PaginatedCollection;

class CategoryCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "knowledgebase_categories";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Category($this->client);
    }
}