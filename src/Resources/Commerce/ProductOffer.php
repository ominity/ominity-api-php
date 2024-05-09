<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\ProductOfferType;

class ProductOffer extends BaseResource
{
    /**
     * Always 'product_offer'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the product.
     *
     * @var int
     */
    public $id;

    /**
     * ID of the product this offer is related to.
     *
     * @var int
     */
    public $productId;

    /**
     * The offer type.
     *
     * @var string
     */
    public $type;

    /**
     * ID of the offer subscription interval. Only if type if "subscription".
     *
     * @var string|null
     */
    public $intervalId;

    /**
     * Minimum quantity that is applicable for this offer.
     *
     * @var integer
     */
    public $quantity;

    /**
     * Prices for this offer.
     *
     * @var \stdClass
     */
    public $prices;

    /** 
     * UTC datetime the page was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the page was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this product offer as a buy once?
     *
     * @return bool
     */
    public function isOnce() {
        return $this->type === ProductOfferType::ONCE;
    }

    /**
     * Is this product offer as a subscription?
     *
     * @return bool
     */
    public function isSubscription() {
        return $this->type === ProductOfferType::SUBSCRIPTION;
    }

     /**
     * Get price by a currency code in ISO-4217 format.
     *
     * @return \stdClass|null
     */
    public function getPrice($currency) {
        if(isset($this->prices->$currency)) {
            return $this->prices->$currency;
        }

        return null;
    }
    
    /**
     * Get price by a currency code in ISO-4217 format.
     *
     * @return SubscriptionInterval
     * @throws ApiException
     */
    public function interval() {
        if (! isset($this->_links->interval->href)) {
            return null;
        }

        return $this->client->commerce->subscriptionIntervals->get($this->intervalId);
    }
}