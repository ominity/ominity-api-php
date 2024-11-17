<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\PaginatedCollection;

class ArticleCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "knowledgebase_articles";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Article($this->client);
    }
}