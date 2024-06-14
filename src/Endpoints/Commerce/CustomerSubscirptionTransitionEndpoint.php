<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Customer;
use Ominity\Api\Resources\Commerce\Product;
use Ominity\Api\Resources\Commerce\ProductCollection;
use Ominity\Api\Resources\Commerce\Subscription;

class CustomerSubscirptionTransitionEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "commerce/customers/{customerId}/subscriptions/{subscriptionId}/transition";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ProductCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new Product($this->client);
    }

    /**
     * Get the transition product for a specific Subscirption.
     *
     * The product offers will have the prorata parameter available 
     * in the price field.
     * 
     * @param Customer $customer
     * @param Subscription $subscription
     * @param int $productId
     * @return Product
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Customer $customer, Subscription $subscription, int $productId, array $parameters = []) {
        if (empty($customer)) {
            throw new ApiException("Customer is empty.");
        }

        if (empty($subscription)) {
            throw new ApiException("Subscription is empty.");
        }

        if (empty($productId)) {
            throw new ApiException("Product ID is empty.");
        }

        return $this->getForId($customer->id, $subscription->id, $productId, $parameters);
    }

    /**
     * Get the transition product for a specific Subscirption ID.
     * 
     * The product offers will have the prorata parameter available 
     * in the price field.
     *
     * @param int $customerId
     * @param int $subscriptionId
     * @param int $productId
     * @return Product
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $customerId, int $subscriptionId, int $productId, array $parameters = []) {
        if (empty($customerId)) {
            throw new ApiException("Customer ID is empty.");
        }

        if (empty($subscriptionId)) {
            throw new ApiException("Subscription ID is empty.");
        }

        if (empty($productId)) {
            throw new ApiException("Product ID is empty.");
        }

        $this->setPathVariables(['customerId' => $customerId, 'subscriptionId' => $subscriptionId]);
        return parent::rest_read($productId, $parameters);
    }

    /**
     * Get all transition product options for a Subscription.
     *
     * @param array $parameters
     *
     * @return ProductCollection
     * @throws ApiException
     */
    public function allFor(Customer $customer, Subscription $subscription, array $parameters = [])
    {
        return $this->allForId($customer->id, $subscription->id, $parameters);
    }

    /**
     * Get all transition product options for a Subscription ID.
     *
     * @param array $parameters
     *
     * @return ProductCollection
     * @throws ApiException
     */
    public function allForId(int $customerId, int $subscriptionId, array $parameters = [])
    {
        $this->setPathVariables(['customerId' => $customerId, 'subscriptionId' => $subscriptionId]);

        return parent::rest_list(null, null, $parameters);
    }
}