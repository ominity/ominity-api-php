<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\OrderLineStatus;
use Ominity\Api\Types\OrderLineType;

class OrderLine extends BaseResource
{
    /**
     * Always 'orderline'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the orderline.
     *
     * @var int
     */
    public $id;

    /**
     * The ID of the order this line belongs to.
     *
     * @var int
     */
    public $orderId;

    /**
     * The type of product bought.
     *
     * @example physical
     * @var string
     */
    public $type;

    /**
     * The ID of the product sold in this line.
     *
     * @var int|null
     */
    public $productId;

    /**
     * The type of product offer.
     *
     * @example once
     * @var string
     */
    public $offerType;

    /**
     * The status of the order line.
     *
     * @var string|OrderLineStatus
     */
    public $status = OrderLineStatus::PENDING;

    /**
     * The number of items in the order line.
     *
     * @var int
     */
    public $quantity;

    /**
     * A description of the order line.
     *
     * @example USB-C to Lightning Cable - 2 meters
     * @var string
     */
    public $name;

    /**
     * The price of a single item in the order line.
     *
     * @var \stdClass
     */
    public $unitPrice;

    /**
     * Any discounts applied to the order line.
     *
     * @var \stdClass|null
     */
    public $discountAmount;

    /**
     * The total amount of the line, including VAT and discounts.
     *
     * @var \stdClass
     */
    public $totalAmount;

    /**
     * The VAT rate applied to the order line. It is defined as a string
     * and not as a float to ensure the correct number of decimals are
     * passed.
     *
     * @example "21.00"
     * @var string
     */
    public $vatRate;

    /**
     * The amount of value-added tax on the line.
     *
     * @var \stdClass
     */
    public $vatAmount;

    /**
     * A link pointing to an image of the product sold.
     *
     * @var string|null
     */
    public $imageUrl;

    /**
     * During creation of the order you can set custom metadata on order lines that is stored with
     * the order, and given back whenever you retrieve that order line.
     *
     * @var \stdClass|mixed|null
     */
    public $metadata;

    /**
     * If a offer type is 'subscription' the subscription interval id will
     * be available here as well.
     *
     * @var int|null
     */
    public $intervalId;

    /** 
     * UTC datetime the customer was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the customer was created in ISO-8601 format.
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
     * @var \stdClass[]
     */
    public $_embedded;

    /**
     * Is this order line still pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === OrderLineStatus::PENDING;
    }

    /**
     * Is this order line shipped?
     *
     * @return bool
     */
    public function isShipped()
    {
        return $this->status === OrderLineStatus::SHIPPED;
    }

    /**
     * Is this payment completed?
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === OrderLineStatus::COMPLETED;
    }

    /**
     * Get the product related to this order line.
     * 
     * @return Product
     */
    public function getProduct() {
        $this->client->commerce->products->get($this->productId);
    }

    /**
     * Get the subscription interval if order line type is 'subscription'
     * 
     * @return SubscriptionInterval
     */
    public function getSubscriptionInterval() {
        if (empty($this->intervalId)) {
            return null;
        }

        $this->client->commerce->subscriptionIntervals->get($this->intervalId);
    }

    /**
     * Is this order line for a physical product?
     *
     * @return bool
     */
    public function isPhysical()
    {
        return $this->type === OrderLineType::PHYSICAL;
    }

    /**
     * Is this order line for a digital product?
     *
     * @return bool
     */
    public function isDigital()
    {
        return $this->type === OrderLineType::DIGITAL;
    }

    /**
     * Is this order line for applying a discount?
     *
     * @return bool
     */
    public function isDiscount()
    {
        return $this->type === OrderLineType::DISCOUNT;
    }
}