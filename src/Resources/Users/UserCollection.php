<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\PaginatedCollection;

class UserCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "users";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new User($this->client);
    }
}