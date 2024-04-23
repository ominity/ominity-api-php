<?php

namespace Ominity\Api\Endpoints\Settings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Settings\Language;
use Ominity\Api\Resources\Settings\LanguageCollection;

class LanguageEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "settings/languages";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Language($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return LanguageCollection|\Ominity\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new LanguageCollection($this->client, $count, $_links);
    }

    /**
     * This is a wrapper method for page
     *
     * @param array $parameters
     *
     * @return LanguageCollection|\Ominity\Api\Resources\BaseCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return parent::rest_list(null, null, $parameters);
    }
}