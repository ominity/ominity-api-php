<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class PaymentMethod extends BaseResource
{
    /**
     * Always 'paymentmethod'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the payment method.
     *
     * @var int
     */
    public $id;

    /**
     * The payment gateway.
     *
     * @var string
     */
    public $gateway;

    /**
     * Label of the payment method.
     *
     * @var string
     */
    public $method;

    /**
     * Icon of the payment method.
     *
     * @var string
     */
    public $icon;

    /**
     * Is this payment method enabled?
     *
     * @var bool
     */
    public $isEnabled;

    /**
     * An object containing value and currency. It represents the minimum payment amount required to use this
     * payment method.
     * 
     * @var \stdClass
     */
    public $minimumAmount;

    /**
     * An object containing value and currency. It represents the maximum payment amount required to use this
     * payment method.
     * 
     * @var \stdClass|null
     */
    public $maximumAmount;

    /**
     * An object containing available features for this payment method. For example mandates or qr codes.
     * 
     * @var \stdClass
     */
    public $features;

    /**
     * The issuers available for this payment method. Only for the methods.
     * Will only be filled when explicitly requested using the query string `include` parameter.
     *
     * @var array|object[]
     */
    public $issuers;

    /** 
     * UTC datetime the payment method was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the payment method was created in ISO-8601 format.
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
     * Can this payment method create mandates?
     *
     * @return bool
     */
    public function supportsMandates()
    {
        return isset($this->features->mandate);
    }

    /**
     * Does this payment method support embedded qr code?
     *
     * @return bool
     */
    public function supportsQRCode()
    {
        return isset($this->features->qrcode);
    }
}