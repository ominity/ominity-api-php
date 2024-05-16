<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\PaginatedCollection;

class UserSocialCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "user_socials";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new UserSocial($this->client);
    }
}