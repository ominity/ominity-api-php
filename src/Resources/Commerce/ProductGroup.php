<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\ProductGroupType;

class ProductGroup extends BaseResource
{
    /**
     * Always 'product_group'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the product group.
     *
     * @var int
     */
    public $id;

    /**
     * The name of the product group.
     *
     * @var string
     */
    public $label;

    /**
     * The type of the product group.
     *
     * @var string
     */
    public $type;

    /**
     * The order of the product group.
     *
     * @var int
     */
    public $order;

    /**
     * Are the reviews in this group grouped?
     *
     * @var bool
     */
    public $isReviewsGrouped;

    /**
     * The products in this group.
     *
     * @var array|\stdClass[]
     */
    public $products;

    /** 
     * UTC datetime the product group was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the product group was created in ISO-8601 format.
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
     * Are products in this group shown as labels?
     *
     * @return bool
     */
    public function isLabel() {
        return $this->type === ProductGroupType::LABEL;
    }

    /**
     * Are products in this group shown as images?
     *
     * @return bool
     */
    public function isImage() {
        return $this->type === ProductGroupType::IMAGE;
    }

    /**
     * Are products in this group shown as colors?
     *
     * @return bool
     */
    public function isColor() {
        return $this->type === ProductGroupType::COLOR;
    }
}