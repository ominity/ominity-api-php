<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\PaginatedCollection;

class TagCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "knowledgebase_tags";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Tag($this->client);
    }
}