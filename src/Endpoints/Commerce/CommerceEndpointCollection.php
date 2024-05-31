<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class CommerceEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Customer resource.
     *
     * @var CustomerEndpoint
     */
    public CustomerEndpoint $customers;

    /**
     * RESTful Invoice resource.
     *
     * @var InvoiceEndpoint
     */
    public InvoiceEndpoint $invoices;

    /**
     * RESTful Order resource.
     *
     * @var OrderEndpoint
     */
    public OrderEndpoint $orders;

    /**
     * RESTful Product resource.
     *
     * @var ProductEndpoint
     */
    public ProductEndpoint $products;

    /**
     * RESTful Product Offer resource.
     *
     * @var ProductOfferEndpoint
     */
    public ProductOfferEndpoint $productOffers;

    /**
     * RESTful Subscription Interval resource.
     *
     * @var SubscriptionIntervalEndpoint
     */
    public $subscriptionIntervals;

    /**
     * RESTful VatValidation resource.
     *
     * @var VatValidationEndpoint
     */
    public VatValidationEndpoint $vatvalidations;

    public function initializeEndpoints()
    {
        $this->customers = new CustomerEndpoint($this->client);
        $this->invoices = new InvoiceEndpoint($this->client);
        $this->orders = new OrderEndpoint($this->client);
        $this->products = new ProductEndpoint($this->client);
        $this->productOffers = new ProductOfferEndpoint($this->client);
        $this->subscriptionIntervals = new SubscriptionIntervalEndpoint($this->client);
        $this->vatvalidations = new VatValidationEndpoint($this->client);
    }
}