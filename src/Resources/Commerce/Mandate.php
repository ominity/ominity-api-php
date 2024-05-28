<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\MandateStatus;

class Mandate extends BaseResource
{
    /**
     * Always 'mandate'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the mandate.
     *
     * @var int
     */
    public $id;

    /**
     * The ID of the customer related to this mandate.
     *
     * @var int
     */
    public $customerId;

    /**
     * The ID of the payment method related to this mandate.
     *
     * @var int
     */
    public $paymentmethodId;

    /**
     * The status of the mandate.
     *
     * @var string
     */
    public $status;

    /**
     * Details of an active mandate are set here. For example, the Direct Debit
     * mandate method will set $details->accountNumber and $details->accountBic.
     *
     * @var \stdClass|null
     */
    public $details;

    /**
     * If a FIRST_MANDATE payment was used to authorized this mandate the payment id will
     * be available here as well.
     *
     * @var int|null
     */
    public $firstPaymentId;

    /** 
     * UTC datetime the mandate was signed is due in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $signedAt;
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
     * Is this mandate still pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === MandateStatus::PENDING;
    }

    /**
     * Is this mandate valid?
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->status === MandateStatus::VALID;
    }

    /**
     * Is this mandate invalid?
     *
     * @return bool
     */
    public function isInvalid()
    {
        return $this->status === MandateStatus::INVALID;
    }

    /**
     * Get the customer related to this mandate.
     *
     * @return Customer
     */
    public function customer()
    {
        return $this->client->commerce->customers->get($this->customerId);
    }

    /**
     * Get the payment method related to this mandate.
     *
     * @return PaymentMethod
     */
    public function paymentMethod()
    {
        return $this->client->settings->paymentmethods->get($this->paymentmethodId);
    }
}