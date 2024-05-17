<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\PaginatedCollection;
use Ominity\Api\Resources\Settings\SocialProvider;

class SocialProviderCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "socialproviders";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new SocialProvider($this->client);
    }
}