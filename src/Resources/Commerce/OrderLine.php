<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Modules\Bookings\Booking;
use Ominity\Api\Resources\ResourceFactory;
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
     * The type and ID of the orderable item.
     *
     * @var \stdClass
     */
    public $orderable;

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
     * UTC datetime the order line was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the order line was created in ISO-8601 format.
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

    /**
     * Get the orderable item related to this order line.
     *
     * @return mixed|null
     */
    public function item()
    {
        if (! isset($this->_embedded->item)) {
            return null;
        }

        // Product
        if ($this->_embedded->item->resource === "product") 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->item,
                new Product($this->client)
            );
        }

        // Subscription
        if ($this->_embedded->item->resource === "subscription") 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->item,
                new Subscription($this->client)
            );
        }

        // Module: Bookings
        if ($this->_embedded->item->resource === "bookings_booking") 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->item,
                new Booking($this->client)
            );
        }

        return $this->_embedded->item;
    }
}