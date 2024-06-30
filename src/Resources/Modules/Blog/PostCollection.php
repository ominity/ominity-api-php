<?php

namespace Ominity\Api\Resources\Modules\Blog;

use Ominity\Api\Resources\PaginatedCollection;

class PostCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "blog_posts";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Post($this->client);
    }
}