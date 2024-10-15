<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;

class ShippingClass extends BaseResource
{
    /**
     * Always 'shipping_class'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the sipping class.
     *
     * @var int
     */
    public $id;

    /**
     * The name of the shipping class.
     *
     * @var string
     */
    public $name;

    /**
     * The description of the shipping class.
     *
     * @var string
     */
    public $description;

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
}