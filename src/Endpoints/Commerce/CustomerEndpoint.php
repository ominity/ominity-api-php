<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\Commerce\Customer;
use Ominity\Api\Resources\Commerce\CustomerCollection;
use Ominity\Api\Resources\LazyCollection;

class CustomerEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/customers";

     /**
     * RESTful CustomerUser resource.
     * 
     * @var CustomerUserEndpoint
     */
    public CustomerUserEndpoint $users;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);
        
        $this->users = new CustomerUserEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Customer($this->client);
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
        return new CustomerCollection($this->client, $count, $_links);
    }

    /**
     * Creates a customer in Ominity.
     *
     * @param array $data An array containing details of the customer.
     * @param array $filters
     *
     * @return Customer
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Update a specific Customer resource
     *
     * Will throw a ApiException if the custoemr id is invalid or the resource cannot be found.
     *
     * @param int $customerId
     * @param array $data
     * @return Customer
     * @throws ApiException
     */
    public function update($customerId, array $data = [])
    {
        if (empty($customerId)) {
            throw new ApiException("Invalid customer ID.");
        }

        return parent::rest_update($customerId, $data);
    }

    /**
     * Retrieve an Customer from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param string $customerId
     * @param array $parameters
     *
     * @return Customer
     * @throws ApiException
     */
    public function get($customerId, array $parameters = [])
    {
        return $this->rest_read($customerId, $parameters);
    }

    /**
     * Retrieves a collection of Customers from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return CustomerCollection
     * @throws ApiException
     */
    public function page($page = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($page, $limit, $parameters);
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