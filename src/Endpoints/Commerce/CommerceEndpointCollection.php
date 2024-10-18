<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class CommerceEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Cart resource.
     *
     * @var CartEndpoint
     */
    public CartEndpoint $carts;

    /**
     * RESTful Category resource.
     *
     * @var CategoryEndpoint
     */
    public CategoryEndpoint $categories;
    
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
     * RESTful Product Group resource.
     *
     * @var ProductGroupEndpoint
     */
    public ProductGroupEndpoint $productGroups;

    /**
     * RESTful Product Offer resource.
     *
     * @var ProductOfferEndpoint
     */
    public ProductOfferEndpoint $productOffers;

    /**
     * RESTful Review resource.
     *
     * @var ReviewEndpoint
     */
    public ReviewEndpoint $reviews;

    /**
     * RESTful ShippingClass resource.
     *
     * @var ShippingClassEndpoint
     */
    public ShippingClassEndpoint $shippingClasses;

    /**
     * RESTful ShippingMethod resource.
     *
     * @var ShippingMethodEndpoint
     */
    public ShippingMethodEndpoint $shippingMethods;

    /**
     * RESTful ShippingZone resource.
     *
     * @var ShippingZoneEndpoint
     */
    public ShippingZoneEndpoint $shippingZones;

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
        $this->carts = new CartEndpoint($this->client);
        $this->categories = new CategoryEndpoint($this->client);
        $this->customers = new CustomerEndpoint($this->client);
        $this->invoices = new InvoiceEndpoint($this->client);
        $this->orders = new OrderEndpoint($this->client);
        $this->products = new ProductEndpoint($this->client);
        $this->productGroups = new ProductGroupEndpoint($this->client);
        $this->productOffers = new ProductOfferEndpoint($this->client);
        $this->reviews = new ReviewEndpoint($this->client);
        $this->shippingClasses = new ShippingClassEndpoint($this->client);
        $this->shippingMethods = new ShippingMethodEndpoint($this->client);
        $this->shippingZones = new ShippingZoneEndpoint($this->client);
        $this->subscriptionIntervals = new SubscriptionIntervalEndpoint($this->client);
        $this->vatvalidations = new VatValidationEndpoint($this->client);
    }
}