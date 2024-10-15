<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\ShippingMethodRateType;

class ShippingMethod extends BaseResource
{
    /**
     * Always 'shipping_method'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the sipping method.
     *
     * @var int
     */
    public $id;

    /**
     * ID of the zone this method is related to.
     *
     * @var int
     */
    public $zoneId;

    /**
     * ID of the class this method is related to.
     *
     * @var int|null
     */
    public $classId;

    /**
     * The icon of the shipping method.
     *
     * @var string
     */
    public $icon;

    /**
     * The name of the shipping method.
     *
     * @var string
     */
    public $name;

    /**
     * The description of the shipping method.
     *
     * @var string
     */
    public $description;

    /**
     * The rate type of the shipping method.
     *
     * @var string
     */
    public $rateType;

    /**
     * The rate of the shipping method.
     * If rateType is "flat_rate" this is an object with 
     * currency codes as keys and prices as values.
     * 
     * @var \stdClass|float
     */
    public $rate;

    /**
     * Is the shipping method enabled?
     *
     * @var bool
     */
    public $isEnabled;

    /** 
     * UTC datetime the shipping method was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the shipping method was created in ISO-8601 format.
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
     * Is this shipping method free?
     *
     * @return bool
     */
    public function isFree() {
        return $this->rateType === ShippingMethodRateType::FREE;
    }

    /**
     * Is this shipping method a flat rate?
     *
     * @return bool
     */
    public function isFlatRate() {
        return $this->rateType === ShippingMethodRateType::FLAT_RATE;
    }

    /**
     * Is this shipping method a percentage rate?
     *
     * @return bool
     */
    public function isPercentage() {
        return $this->rateType === ShippingMethodRateType::PERCENTAGE;
    }

    /**
     * Get rate by a currency code in ISO-4217 format.
     *
     * @return float|null
     */
    public function getRate($currency) {
        if($this->isFree()) {
            return 0;
        }

        if($this->isPercentage()) {
            return $this->rate;
        }
        
        if(isset($this->rate->$currency)) {
            return $this->rate->$currency->value;
        }

        return null;
    }
}