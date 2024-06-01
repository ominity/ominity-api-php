<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseResource;

class PaymentMethodIssuer extends BaseResource
{
    /**
     * Always 'paymentmethod'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the issuer.
     *
     * @var int
     */
    public $id;

    /**
     * The payment method ID related to this issuer.
     *
     * @var string
     */
    public $paymentmethodId;

    /**
     * Unique issuer identifier.
     *
     * @var string
     */
    public $issuer;

    /**
     * Display name of the issuer.
     *
     * @var string
     */
    public $name;

    /**
     * Icon of the issuer.
     *
     * @var string
     */
    public $icon;

    /**
     * Is this issuer enabled?
     *
     * @var bool
     */
    public $isEnabled;

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
}