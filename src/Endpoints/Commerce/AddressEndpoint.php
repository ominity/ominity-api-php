<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Address;
use Ominity\Api\Resources\Commerce\AddressCollection;
use Ominity\Api\Resources\Commerce\Customer;

class AddressEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "commerce/customers/{customerId}/addresses";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new AddressCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new Address($this->client);
    }

    /**
     * Create a new address for a specific Customer.
     *
     * @param Customer $customer
     * @param array $data
     * @param array $filters
     *
     * @return Address
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(Customer $customer, array $data, array $filters = [])
    {
        return $this->createForId($customer->id, $data, $filters);
    }

    /**
     * Create a new address for a specific Customer ID.
     *
     * @param int $customerId
     * @param array $data
     * @param array $filters
     *
     * @return Address
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($customerId, array $data, array $filters = [])
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return parent::rest_create($data, $filters);
    }

    /**
     * Update an address for a specific Customer.
     *
     * @param Customer $customer
     * @param int $addressId
     * @param array $data
     *
     * @return Address
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function updateFor(Customer $customer, int $addressId, array $data)
    {
        return $this->updateForId($customer->id, $addressId, $data);
    }

    /**
     * Update an address for a specific Customer ID.
     *
     * @param int $customerId
     * @param int $addressId
     * @param array $data
     *
     * @return Address
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function updateForId($customerId, int $addressId, array $data)
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return parent::rest_update($addressId, $data);
    }

    /**
     * Deletes the given address for a specific Customer.
     *
     * Will throw a ApiException if the address id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param Customer $customer
     * @param int $addressId
     *
     * @param array $data
     * @return Address
     * @throws ApiException
     */
    public function deleteFor(Customer $customer, int $addressId, array $data = [])
    {
        return $this->deleteForId($customer->id, $addressId, $data);
    }

    /**
     * Deletes the given address for a specific Customer ID.
     *
     * Will throw a ApiException if the address id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param int $customerId
     * @param int $addressId
     *
     * @param array $data
     * @return Address
     * @throws ApiException
     */
    public function deleteForId(int $customerId, int $addressId, array $data = [])
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return $this->rest_delete($addressId, $data);
    }

    /**
     * Get the address for a specific Customer.
     *
     * @param Customer $product
     * @param int $addressId
     * @return Address
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Customer $customer, int $addressId, array $parameters = []) {
        if (empty($customer)) {
            throw new ApiException("Customer is empty.");
        }

        if (empty($addressId)) {
            throw new ApiException("Address ID is empty.");
        }

        return $this->getForId($customer->id, $addressId, $parameters);
    }

    /**
     * Get the address for a specific Customer ID.
     *
     * @param int $customerId
     * @param int $addressId
     * @return Address
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $customerId, int $addressId, array $parameters = []) {
        if (empty($customerId)) {
            throw new ApiException("Customer ID is empty.");
        }

        if (empty($addressId)) {
            throw new ApiException("Address ID is empty.");
        }

        $this->setPathVariables(['customerId' => $customerId]);
        return parent::rest_read($addressId, $parameters);
    }

    /**
     * List the addresses for a specific Customer.
     *
     * @param Customer $customer
     * @param array $parameters
     * @return AddressCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Customer $customer, array $parameters = [])
    {
        return $this->listForId($customer->id, $parameters);
    }

    /**
     * Create an iterator for iterating over addresses for the given customer retrieved from Ominity.
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
     * List the addresses for a specific Customer ID.
     *
     * @param int $customerId
     * @param array $parameters
     * @return AddressCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $customerId, array $parameters = [])
    {
        $this->setPathVariables(['customerId' => $customerId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over addresses for the given customer id retrieved from Ominity.
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