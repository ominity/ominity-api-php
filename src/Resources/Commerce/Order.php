<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\OrderStatus;

class Order extends BaseResource
{
    /**
     * Always 'order'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the order.
     *
     * @var int
     */
    public $id;

    /**
     * If a customer was related to this order, the customer's ID will
     * be available here as well.
     *
     * @var int|null
     */
    public $customerId;

    /**
     * If a invoice was created to this order, the invoice ID will
     * be available here as well.
     *
     * @var int|null
     */
    public $invoiceId;

    /**
     * If a status of this order is not DRAFT the order number will
     * be available here as well.
     *
     * @var string|null
     */
    public $number;

    /**
     * The status of the order.
     *
     * @var string|OrderStatus
     */
    public $status = OrderStatus::DRAFT;

    /**
     * If this order was placed as a company the company name will
     * be available here as well.
     *
     * @var string|null
     */
    public $companyName;

    /**
     * If this order was placed as a company the company vat number will
     * be available here as well.
     *
     * @var string|null
     */
    public $companyVat;
    
    /**
     * Subtotal amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $subtotalAmount;

    /**
     * Discount amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $discountAmount;

    /**
     * Total amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $totalAmount;

     /**
     * VAT amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $vatAmount;

    /**
     * Amount paid object containing the value and currency
     *
     * @var \stdClass
     */
    public $amountPaid;

    /** 
     * UTC datetime the order was completed in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $completedAt;

    /**
     * The order lines contain the actual things the customer bought.
     *
     * @var array|object[]
     */
    public $lines;

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
     * @var \stdClass|null
     */
    public $_embedded;

    /**
     * Is this payment still open / ongoing?
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === OrderStatus::DRAFT;
    }

    /**
     * Is this order still unpaid?
     *
     * @return bool
     */
    public function isUnpaid()
    {
        return $this->status === OrderStatus::PENDING_PAYMENT;
    }

    /**
     * Is this order paid and waiting approvement?
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->status === OrderStatus::OPEN;
    }

    /**
     * Is this order accepted?
     *
     * @return bool
     */
    public function isAccepted()
    {
        return $this->status === OrderStatus::ACCEPTED;
    }

    /**
     * Is this order completed?
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === OrderStatus::COMPLETED;
    }

    /**
     * Is this order partially completed?
     *
     * @return bool
     */
    public function isPartiallyCompleted()
    {
        return $this->status === OrderStatus::PARTIALLY_COMPLETED;
    }

    /**
     * Is this order shipped?
     *
     * @return bool
     */
    public function isShipped()
    {
        return $this->status === OrderStatus::SHIPPED;
    }

    /**
     * Is this order requested to be cancelled?
     *
     * @return bool
     */
    public function isCancelRequested()
    {
        return $this->status === OrderStatus::CANCEL_REQUEST;
    }

    /**
     * Is this order cancelled?
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === OrderStatus::CANCELLED;
    }

    /**
     * Is this order requested to be returned?
     *
     * @return bool
     */
    public function isReturnRequested()
    {
        return $this->status === OrderStatus::RETURN_REQUEST;
    }

    /**
     * Is this order return request accepted?
     *
     * @return bool
     */
    public function isReturnAccepted()
    {
        return $this->status === OrderStatus::RETURN_ACCEPTED;
    }

    /**
     * Is this order returned?
     *
     * @return bool
     */
    public function isReturned()
    {
        return $this->status === OrderStatus::RETURNED;
    }

    /**
     * Get the customer related to this order.
     *
     * @return Customer|null
     */
    public function customer()
    {
        if (empty($this->customerId)) {
            return null;
        }

        return $this->client->commerce->customers->get($this->customerId);
    }

    /**
     * Get the invoice related to this order.
     *
     * @return Invoice|null
     */
    public function invoice()
    {
        if (empty($this->invoiceId)) {
            return null;
        }

        return $this->client->commerce->invoices->get($this->invoiceId);
    }

    /**
     * Get the line value objects
     *
     * @return OrderLineCollection
     */
    public function lines()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            OrderLine::class,
            $this->lines
        );
    }

    /**
     * Create a new payment for this Order.
     *
     * @param array $data
     * @param array $filters
     * @return \Ominity\Api\Resources\Commerce\Payment
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createPayment($data, $filters = [])
    {
        return $this->client->commerce->orders->payments->createFor($this, $data, $filters);
    }

    /**
     * Retrieve the payments for this order.
     * Requires the order to be retrieved using the embed payments parameter.
     *
     * @return null|\Ominity\Api\Resources\Commerce\PaymentCollection
     */
    public function payments()
    {
        if (isset($this->_embedded, $this->_embedded->payments)) 
        {
            return ResourceFactory::createCursorResourceCollection(
                $this->client,
                $this->_embedded->payments,
                Payment::class
            );
        }

        return $this->client->commerce->orders->payments->allFor($this);
    }
}