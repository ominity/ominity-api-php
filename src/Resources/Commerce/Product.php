<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
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
     * MPN of the product.
     *
     * @var string
     */
    public $mpn;

    /**
     * ASIN of the product.
     *
     * @var string
     */
    public $asin;

    /**
     * Type of the product.
     *
     * @var string|ProductType
     */
    public $type;

    /**
     * Category ID of the product.
     *
     * @var int|null
     */
    public $categoryId;

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
     * Get list of all routes for this product. 
     * It has a locale as key and the route as value.
     *
     * @var \stdClass
     */
    public $routes;

    /**
     * Custom field values of the product.
     *
     * @var \stdClass
     */
    public $customFields;

    /**
     * The offers for this product.
     *
     * @var array|object[]
     */
    public $offers;

    /** 
     * UTC datetime the product was published in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $publishedAt;

    /** 
     * UTC datetime the product was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the product was created in ISO-8601 format.
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
     * Is this product free?
     *
     * @return bool
     */
    public function isFree() {
        return $this->offers()->count === 0;
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

    /**
     * Get the product groups for this product.
     *
     * @return ProductGroupCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function groups()
    {
        if (isset($this->_embedded, $this->_embedded->product_groups)) 
        {
            return ResourceFactory::createCursorResourceCollection(
                $this->client, 
                $this->_embedded->product_groups,
                ProductGroup::class
            );
        }
        
        return $this->client->commerce->productGroups->all([
            'filter' => [
                'product' => $this->id
            ]
        ]);
    }

    /**
     * Get the category of this product.
     *
     * @return Category|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function category()
    {
        if(empty($this->categoryId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->category)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->category,
                new Category($this->client)
            );
        }
        
        return $this->client->commerce->categories->get($this->categoryId);
    }

    /**
     * Get the route for a specific locale
     * 
     * @param string $locale
     * @return Route|null
     */
    public function getRoute($locale)
    {
        return ResourceFactory::createFromApiResult(
            $this->routes->{$locale} ?? null,
            new Route($this->client)
        );
    }

    /**
     * Get the routes for this product.
     *
     * @return RouteCollection
     */
    public function routes()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            Route::class,
            array_values((array) $this->routes)
        );
    }
}