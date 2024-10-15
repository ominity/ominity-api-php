<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class ShippingZone extends BaseResource
{
    /**
     * Always 'shipping_zone'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the sipping zone.
     *
     * @var int
     */
    public $id;

    /**
     * The name of the shipping zone.
     *
     * @var string
     */
    public $name;

    /**
     * The regions of the shipping zone.
     * Contains country codes as keys and optional postal code rules as values.
     *
     * @var \stdClass
     */
    public $regions;

    /**
     * Is the shipping zone enabled?
     *
     * @var bool
     */
    public $isEnabled;

    /**
     * The order of the shipping zone.
     *
     * @var int
     */
    public $order;

    /** 
     * UTC datetime the shipping zone was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the shipping zone was created in ISO-8601 format.
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
     * Get the shipping methods for this zone.
     *
     * @return ShippingMethodCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function methods()
    {
        if (isset($this->_embedded, $this->_embedded->shipping_methods)) 
        {
            return ResourceFactory::createBaseResourceCollection(
                $this->client, 
                ShippingMethod::class,
                $this->_embedded->shipping_methods
            );
        }
        
        return $this->client->commerce->shippingMethods->all([
            'filter' => [
                'zone' => $this->id
            ]
        ]);
    }
}