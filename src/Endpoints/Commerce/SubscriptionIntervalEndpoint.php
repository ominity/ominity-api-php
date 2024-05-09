<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\SubscriptionInterval;
use Ominity\Api\Resources\Commerce\SubscriptionIntervalCollection;
use Ominity\Api\Resources\LazyCollection;

class SubscriptionIntervalEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/subscriptions/intervals";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new SubscriptionInterval($this->client);
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
        return new SubscriptionIntervalCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an Subscription Interval from the API.
     *
     * Will throw a ApiException if the interval id is invalid or the resource cannot be found.
     *
     * @param string $intervalId
     * @param array $parameters
     *
     * @return SubscriptionInterval
     * @throws ApiException
     */
    public function get($intervalId, array $parameters = [])
    {
        return $this->rest_read($intervalId, $parameters);
    }

    /**
     * Retrieves a collection of Subscription Intervals from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return SubscriptionIntervalCollection
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
     * @return SubscriptionIntervalCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages retrieved from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $page = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($page, $limit, $parameters, $iterateBackwards);
    }
}