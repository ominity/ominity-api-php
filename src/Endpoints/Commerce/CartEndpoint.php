<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\Commerce\Cart;
use Ominity\Api\Resources\Commerce\CartCollection;
use Ominity\Api\Resources\LazyCollection;

class CartEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/carts";

    /**
     * RESTful CartItem resource.
     * 
     * @var CartItemEndpoint
     */
    public CartItemEndpoint $items;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);
        
        $this->items = new CartItemEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Cart($this->client);
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
        return new CartCollection($this->client, $count, $_links);
    }

    /**
     * Create a new cart.
     *
     * @param array $data
     * @param array $filters
     *
     * @return Cart
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function create(array $data, array $filters = [])
    {
        return parent::rest_create($data, $filters);
    }

    /**
     * Update a specific Cart resource
     *
     * Will throw a ApiException if the cart id is invalid or the resource cannot be found.
     *
     * @param string $cartId
     * @param array $data
     * @return Cart
     * @throws ApiException
     */
    public function update($cartId, array $data = [])
    {
        if (empty($cartId)) {
            throw new ApiException("Invalid cart ID.");
        }

        return parent::rest_update($cartId, $data);
    }

    /**
     * Retrieve an cart from the API.
     *
     * Will throw a ApiException if the cart id is invalid or the resource cannot be found.
     *
     * @param string $cartId
     * @param array $parameters
     *
     * @return Cart
     * @throws ApiException
     */
    public function get($cartId, array $parameters = [])
    {
        return $this->rest_read($cartId, $parameters);
    }

    /**
     * Retrieves a collection of carts from the API.
     *
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return CartCollection
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
     * @return CartCollection
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