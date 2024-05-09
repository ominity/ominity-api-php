<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\ProductType;

class Product extends BaseResource
{
    /**
     * Always 'product'
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
     * SKU of the product.
     *
     * @var string
     */
    public $sku;

    /**
     * EAN of the product.
     *
     * @var string
     */
    public $ean;

    /**
     * Type of the product.
     *
     * @var string|ProductType
     */
    public $type;

    /**
     * Title of the product.
     *
     * @var string
     */
    public $title;

    /**
     * Short title of the product.
     *
     * @var string
     */
    public $shortTitle;

    /**
     * Description of the product with HTML markup. 
     *
     * @var string
     */
    public $description;

    /**
     * Short description of the product. 
     *
     * @var string
     */
    public $shortDescription;

    /**
     * Searches of the product.
     *
     * @var array
     */
    public $searches;

    /**
     * Bulletpoints of the product.
     *
     * @var array
     */
    public $bulletpoints;

    /**
     * Cover image of the product. 
     *
     * @var string
     */
    public $coverImage;

    /**
     * Additional images of the product.
     *
     * @var array
     */
    public $additionalImages;

    /**
     * Additional field values of the product.
     *
     * @var \stdClass
     */
    public $fields;

    /**
     * The offers for this product.
     *
     * @var array|object[]
     */
    public $offers;

    /** 
     * UTC datetime the page was published in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $publishedAt;

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

    /**
     * Is this a physical product?
     *
     * @return bool
     */
    public function isPhysical() {
        return $this->type === ProductType::PHYSICAL;
    }

    /**
     * Is this a virtual product?
     *
     * @return bool
     */
    public function isVirtual() {
        return $this->type === ProductType::VIRTUAL;
    }

    /**
     * Is this product a service?
     *
     * @return bool
     */
    public function isService() {
        return $this->type === ProductType::SERVICE;
    }

    /**
     * Is this page published?
     *
     * @return bool
     */
    public function isPublished()
    {
        if (is_null($this->publishedAt)) {
            return false;
        }

        $publishedTimestamp = strtotime($this->publishedAt);
        $currentTimestamp = time();

        return $publishedTimestamp <= $currentTimestamp;
    }

    /**
     * Is product stock enabled?
     *
     * @return bool
     */
    public function isStockEnabled()
    {
        return !is_null($this->stock);
    }

     /**
     * Get the offer value objects
     *
     * @return ProductOfferCollection
     */
    public function offers() {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            ProductOffer::class,
            $this->offers
        );
    }
}