<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;

class Currency extends BaseResource
{
    /**
     * Always 'currency'
     *
     * @var string
     */
    public $resource;

    /**
     * Code of the currency in ISO 4217 format.
     *
     * @var string
     */
    public $code;

    /**
     * Name of the currency.
     *
     * @var string
     */
    public $name;

    /**
     * Conversion rate of the currency to the default currency.
     *
     * @var float
     */
    public $conversion;

    /**
     * Format of the currency.
     * Contains prefix, suffix, decimal separator and thousand separator.
     *
     * @var \stdClass
     */
    public $format;

    /**
     * Is the currency enabled.
     *
     * @var bool
     */
    public $isEnabled;

    /**
     * Is the currency the default currency.
     *
     * @var bool
     */
    public $isDefault;

    /**
     * @var \stdClass
     */
    public $_links;
}