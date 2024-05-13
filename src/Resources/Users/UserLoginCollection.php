<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\PaginatedCollection;

class UserLoginCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "user_logins";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new UserLogin($this->client);
    }
}