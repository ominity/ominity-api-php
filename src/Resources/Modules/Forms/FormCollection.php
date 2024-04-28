<?php

namespace Ominity\Api\Resources\Modules\Forms;

use Ominity\Api\Resources\PaginatedCollection;

class FormCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "forms";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Form($this->client);
    }
}