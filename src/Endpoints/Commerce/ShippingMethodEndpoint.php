<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\ShippingMethod;
use Ominity\Api\Resources\Commerce\ShippingMethodCollection;
use Ominity\Api\Resources\LazyCollection;

class ShippingMethodEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/shipping-methods";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new ShippingMethod($this->client);
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
        return new ShippingMethodCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an shipping method from the API.
     *
     * Will throw a ApiException if the shipping method id is invalid or the resource cannot be found.
     *
     * @param int $shippingMethodId
     * @param array $parameters
     *
     * @return ShippingMethod
     * @throws ApiException
     */
    public function get($shippingMethodId, array $parameters = [])
    {
        return $this->rest_read($shippingMethodId, $parameters);
    }

    /**
     * Retrieves a collection of shipping methods from the API.
     *
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return ShippingMethodCollection
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
     * @return ShippingMethodCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages retrieved from the API.
     *
     * @param int $page The page number to request
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