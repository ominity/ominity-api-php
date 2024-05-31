<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\Commerce\Order;
use Ominity\Api\Resources\Commerce\OrderCollection;
use Ominity\Api\Resources\LazyCollection;

class OrderEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/orders";

    /**
     * RESTful Payment resource.
     *
     * @var OrderPaymentEndpoint
     */
    public OrderPaymentEndpoint $payments;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);
        
        $this->payments = new OrderPaymentEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Order($this->client);
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
        return new OrderCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an order from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param string $orderId
     * @param array $parameters
     *
     * @return Order
     * @throws ApiException
     */
    public function get($orderId, array $parameters = [])
    {
        return $this->rest_read($orderId, $parameters);
    }

    /**
     * Retrieves a collection of orders from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return OrderCollection
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
     * @return OrderCollection
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