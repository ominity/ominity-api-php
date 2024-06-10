<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\SubscriptionStatus;

class Subscription extends BaseResource
{
    /**
     * Always 'subscription'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the subscription.
     *
     * @var int
     */
    public $id;

    /**
     * The ID of the customer related to this subscription.
     *
     * @var int
     */
    public $customerId;

    /**
     * The ID of the product related to this subscription.
     *
     * @var int
     */
    public $productId;

    /**
     * The ID of the interval for this subscription
     *
     * @var int
     */
    public $intervalId;

    /**
     * The status of the subscription.
     *
     * @var string
     */
    public $status;
    
    /**
     * First payment amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $firstAmount;

    /**
     * Recurring payment amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $recurringAmount;

    /**
     * Is this subscription pausable by the customer?
     *
     * @var bool
     */
    public $isPausable;

    /** 
     * UTC datetime the subscription will expire in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $expiresAt;

    /** 
     * UTC datetime the subscription next payment is due in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $dueAt;
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
     * Is this subscription still pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === SubscriptionStatus::PENDING;
    }

    /**
     * Is this subscription active?
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === SubscriptionStatus::ACTIVE;
    }

    /**
     * Is this subscription cancelled?
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === SubscriptionStatus::CANCELLED;
    }

    /**
     * Is this subscription paused?
     *
     * @return bool
     */
    public function isPaused()
    {
        return $this->status === SubscriptionStatus::PAUSED;
    }

    /**
     * Is this subscription paused?
     *
     * @return bool
     */
    public function isSuspended()
    {
        return $this->status === SubscriptionStatus::SUSPENDED;
    }

    /**
     * Is this subscription terminated?
     *
     * @return bool
     */
    public function isTerminated()
    {
        return $this->status === SubscriptionStatus::TERMINATED;
    }

    /**
     * Get the customer related to this subscription.
     *
     * @return Customer
     */
    public function customer()
    {
        return $this->client->commerce->customers->get($this->customerId);
    }

    /**
     * Get the product related to this subscription.
     *
     * @return Product
     */
    public function product()
    {
        if (isset($this->_embedded, $this->_embedded->product)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->product,
                new Product($this->client)
            );
        }

        return $this->client->commerce->products->get($this->productId);
    }

    /**
     * Get the interval related to this subscription.
     *
     * @return SubscriptionInterval
     */
    public function interval()
    {
        if (isset($this->_embedded, $this->_embedded->interval)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->interval,
                new SubscriptionInterval($this->client)
            );
        }

        return $this->client->commerce->subscriptionIntervals->get($this->intervalId);
    }
}