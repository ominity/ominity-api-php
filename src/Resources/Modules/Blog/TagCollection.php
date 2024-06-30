<?php

namespace Ominity\Api\Resources\Modules\Blog;

use Ominity\Api\Resources\PaginatedCollection;

class TagCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "blog_tags";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Tag($this->client);
    }
}