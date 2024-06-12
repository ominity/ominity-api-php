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