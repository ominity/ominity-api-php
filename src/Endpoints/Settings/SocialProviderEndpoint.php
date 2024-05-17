<?php

namespace Ominity\Api\Endpoints\Settings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Settings\SocialProvider;
use Ominity\Api\Resources\Settings\SocialProviderCollection;

class SocialProviderEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "settings/socialproviders";

    /**
     * RESTful SocialProviderUser resource.
     * 
     * @var SocialProviderUserEndpoint
     */
    public SocialProviderUserEndpoint $users;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);
        
        $this->users = new SocialProviderUserEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new SocialProvider($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Ominity\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new SocialProviderCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an SocialProvider from the API.
     *
     * Will throw a ApiException if the provider id is invalid or the resource cannot be found.
     *
     * @param int $providerId
     * @param array $parameters
     *
     * @return SocialProvider
     * @throws ApiException
     */
    public function get($providerId, array $parameters = [])
    {
        return $this->rest_read($providerId, $parameters);
    }

    /**
     * Retrieves a collection of Social Providers from the API.
     *
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return SocialProviderCollection
     * @throws ApiException
     */
    public function page($page = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for page
     *
     * @param array $parameters
     *
     * @return SocialProviderCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages from the API.
     *
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?int $page = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($page, $limit, $parameters, $iterateBackwards);
    }
}
