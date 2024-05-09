<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\SubscriptionIntervalUnit;

class SubscriptionInterval extends BaseResource
{
    /**
     * Always 'subscription_interval'
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
     * Interval name of the subscription interval.
     *
     * @var string
     */
    public $name;

    /**
     * The frequency of the interval.
     *
     * @var int
     */
    public $frequency;

    /**
     * The unit of the interval.
     *
     * @var string|SubscriptionIntervalUnit
     */
    public $unit;

    /**
     * Days of the week (monday = 1) the interval is limited to. Empty array equals to wildcard.
     *
     * @var array
     */
    public $daysOfWeek;

    /**
     * Days of the month the interval is limited to. Empty array equals to wildcard.
     *
     * @var array
     */
    public $daysOfMonth;

    /**
     * Months the interval is limited to. Empty array equals to wildcard.
     *
     * @var array
     */
    public $months;

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
}