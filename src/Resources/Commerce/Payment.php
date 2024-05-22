<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Settings\PaymentMethod;
use Ominity\Api\Types\PaymentStatus;
use Ominity\Api\Types\PaymentType;

class Payment extends BaseResource
{
    /**
     * Always 'payment'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the customer.
     *
     * @var int
     */
    public $id;

    /**
     * Payment Method ID that is used for this payment.
     *
     * @var int
     */
    public $paymentmethodId;

    /**
     * The type of the payment.
     *
     * @var string
     */
    public $type = PaymentType::ONEOFF;

    /**
     * If a customer was related to this payment, the customer's ID will
     * be available here as well.
     *
     * @var int|null
     */
    public $customerId;

    /**
     * Amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * Description of the payment that is shown to the customer during the payment,
     * and possibly on the bank or credit card statement.
     *
     * @var string
     */
    public $description;

    /**
     * The status of the payment.
     *
     * @var string
     */
    public $status = PaymentStatus::OPEN;

    /** 
     * UTC datetime the customer was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $expiresAt;

    /** 
     * UTC datetime the customer was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $completedAt;

    /**
     * Redirect URL set on this payment
     *
     * @var string
     */
    public $redirectUrl;

    /**
     * The mandate ID this payment belongs to.
     *
     * @var int|null
     */
    public $mandateId;

    /**
     * The order ID this payment belongs to.
     *
     * @var int|null
     */
    public $orderId;

    /**
     * Details of a successfully paid payment are set here. For example, the iDEAL
     * payment method will set $details->accountName and $details->accountNumber.
     *
     * @var \stdClass|null
     */
    public $details;

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
     * Is this payment still open / ongoing?
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->status === PaymentStatus::OPEN;
    }

    /**
     * Is this payment still pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === PaymentStatus::PENDING;
    }

    /**
     * Is this payment completed?
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === PaymentStatus::COMPLETED;
    }

    /**
     * Is this payment authorized?
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->status === PaymentStatus::COMPLETED;
    }

    /**
     * Is this payment still cancelled?
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === PaymentStatus::CANCELLED;
    }

    /**
     * Is this payment expired?
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->status === PaymentStatus::EXPIRED;
    }

    /**
     * Is this payment failed?
     *
     * @return bool
     */
    public function isFailed()
    {
        return $this->status === PaymentStatus::FAILED;
    }

    /**
     * Check whether 'type' is set to 'mandate_first'. If a 'mandate_first' payment has been
     * completed successfully, the consumer's account may be charged automatically
     * using mandate payments.
     *
     * @return bool
     */
    public function hasTypeFirst()
    {
        return $this->sequenceType === PaymentType::FIRST_MANDATE;
    }

    /**
     * Check whether 'type' is set to 'mandate'. This type of payment is
     * processed without involving
     * the consumer.
     *
     * @return bool
     */
    public function hasTypeMandate()
    {
        return $this->sequenceType === PaymentType::MANDATE;
    }

    /**
     * Get the checkout URL where the customer can complete the payment.
     *
     * @return string|null
     */
    public function getCheckoutUrl()
    {
        if (empty($this->_links->checkout)) {
            return null;
        }

        return $this->_links->checkout->href;
    }

    /**
     * Get the qr code image URL.
     *
     * @return string|null
     */
    public function getQrCode()
    {
        if (empty($this->_links->details->qrcode)) {
            return null;
        }

        return $this->_links->details->qrcode;
    }

    /**
     * Get the customer related to this payment.
     *
     * @return Customer
     */
    public function getCustomer()
    {
        if (empty($this->customerId)) {
            return null;
        }

        return $this->client->commerce->customers->get($this->customerId);
    }

    /**
     * Get the qr code image URL.
     *
     * @return PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->client->settings->paymentmethods->get($this->paymentmethodId);
    }
}