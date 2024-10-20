<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Currency;
use Ominity\Api\Resources\Commerce\CurrencyCollection;
use Ominity\Api\Resources\LazyCollection;

class CurrencyEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/currencies";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Currency($this->client);
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
        return new CurrencyCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an currency from the API.
     *
     * Will throw a ApiException if the review id is invalid or the resource cannot be found.
     *
     * @param string $code
     * @param array $parameters
     *
     * @return Currency
     * @throws ApiException
     */
    public function get($code, array $parameters = [])
    {
        return $this->rest_read($code, $parameters);
    }

    /**
     * Retrieves a collection of currencies from the API.
     *
     * @param array $parameters
     *
     * @return CurrencyCollection
     * @throws ApiException
     */
    public function list(array $parameters = [])
    {
        return $this->rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over currencies retrieved from the API.
     *
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator( array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}