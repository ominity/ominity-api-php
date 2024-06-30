<?php

namespace Ominity\Api\Resources\Modules\Blog;

use Ominity\Api\Resources\PaginatedCollection;

class CategoryCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "blog_categories";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Category($this->client);
    }
}