<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Customer;
use Ominity\Api\Resources\Commerce\CustomerUser;
use Ominity\Api\Resources\Commerce\CustomerUserCollection;

class CustomerUserEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "commerce/customers/{customerId}/users";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new CustomerUserCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new CustomerUser($this->client);
    }

    /**
     * Create a new user entry for a specific Customer.
     *
     * @param Customer $customer
     * @param array $data
     * @param array $filters
     *
     * @return CustomerUser
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(Customer $customer, array $data, array $filters = [])
    {
        return $this->createForId($customer->id, $data, $filters);
    }

    /**
     * Create a new user entry for a specific Customer ID.
     *
     * @param int $customerId
     * @param array $data
     * @param array $filters
     *
     * @return CustomerUser
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($customerId, array $data, array $filters = [])
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return parent::rest_create($data, $filters);
    }

    /**
     * Get the user for a specific Customer.
     *
     * @param Customer $product
     * @param int $userId
     * @return CustomerUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Customer $customer, int $userId, array $parameters = []) {
        if (empty($customer)) {
            throw new ApiException("Customer is empty.");
        }

        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        return $this->getForId($customer->id, $userId, $parameters);
    }

    /**
     * Get the user for a specific Customer ID.
     *
     * @param int $customerId
     * @param int $userId
     * @return CustomerUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $customerId, int $userId, array $parameters = []) {
        if (empty($customerId)) {
            throw new ApiException("Customer ID is empty.");
        }

        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        $this->setPathVariables(['customerId' => $customerId]);
        return parent::rest_read($userId, $parameters);
    }

    /**
     * Retrieves a collection of users for a specific Customer.
     *
     * @param Customer $customer
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return CustomerUserCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageFor(Customer $customer, $page = null, $limit = null, array $parameters = [])
    {
        return $this->pageForId($customer->id, $page, $limit, $parameters);
    }

     /**
     * Retrieves a collection of users for a specific Customer ID.
     *
     * @param int $customerId
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return CustomerUserCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageForId(int $customerId, $page = null, $limit = null, array $parameters = [])
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return parent::rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for pageFor
     *
     * @param Customer $customer
     * @param array $parameters
     *
     * @return CustomerUserCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function allFor(Customer $customer, array $parameters = [])
    {
        return $this->pageFor($customer, null, null, $parameters);
    }

    /**
     * This is a wrapper method for pageForId
     *
     * @param int $customerId
     * @param array $parameters
     * @return CustomerUserCollection
     * 
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function allForId(int $customerId, array $parameters = [])
    {
        return $this->pageForId($customerId, null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over users for the given customer retrieved from Ominity.
     *
     * @param Customer $customer
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Customer $customer, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($customer->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over users for the given customer id retrieved from Ominity.
     *
     * @param int $customerId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $customerId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}