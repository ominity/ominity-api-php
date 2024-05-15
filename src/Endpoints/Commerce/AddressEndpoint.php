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
    protected $resourcePath = "commerce/customers_addresses";

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

        $this->parentId = $customerId;
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
        $this->parentId = $customerId;

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
        $this->parentId = $customerId;

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}