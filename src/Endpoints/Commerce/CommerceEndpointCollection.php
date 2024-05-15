<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class CommerceEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Address resource.
     *
     * @var AddressEndpoint
     */
    public $addresses;

    /**
     * RESTful Customer resource.
     *
     * @var CustomerEndpoint
     */
    public $customers;

    /**
     * RESTful Product resource.
     *
     * @var ProductEndpoint
     */
    public $products;

    /**
     * RESTful Product Offer resource.
     *
     * @var ProductOfferEndpoint
     */
    public $productOffers;

    /**
     * RESTful Subscription Interval resource.
     *
     * @var SubscriptionIntervalEndpoint
     */
    public $subscriptionIntervals;

    public function initializeEndpoints()
    {
        $this->addresses = new AddressEndpoint($this->client);
        $this->customers = new CustomerEndpoint($this->client);
        $this->products = new ProductEndpoint($this->client);
        $this->productOffers = new ProductOfferEndpoint($this->client);
        $this->subscriptionIntervals = new SubscriptionIntervalEndpoint($this->client);
    }
}