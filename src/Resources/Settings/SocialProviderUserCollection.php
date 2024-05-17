<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\PaginatedCollection;
use Ominity\Api\Resources\Settings\SocialProviderUser;

class SocialProviderUserCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "socialprovider_users";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new SocialProviderUser($this->client);
    }
}