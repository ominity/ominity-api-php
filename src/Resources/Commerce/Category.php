<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
use Ominity\Api\Resources\ResourceFactory;

class Category extends BaseResource
{
    /**
     * Always 'category'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the category.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the category.
     *
     * @var string
     */
    public $name;

    /**
     * Slug of the category.
     *
     * @var string
     */
    public $slug;

    /**
     * Full slug of the category.
     *
     * @var string
     */
    public $fullSlug;

    /**
     * Description of the category.
     *
     * @var string
     */
    public $description;

    /**
     * Cover image of the category.
     *
     * @var string|null
     */
    public $coverImage;

    /**
     * Parent category ID of the category.
     *
     * @var int|null
     */
    public $parentId;

    /**
     * The amount of products in this category.
     *
     * @var int
     */
    public $productsCount;

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
     * UTC datetime the category was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the category was created in ISO-8601 format.
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
     * Get the parent category of this category.
     *
     * @return Category|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function parent()
    {
        if(empty($this->parentId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->parent)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->parent,
                new Category($this->client)
            );
        }
        
        return $this->client->commerce->categories->get($this->parentId);
    }

    /**
     * Get the children categories of this category.
     *
     * @return CategoryCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function children()
    {
        if (isset($this->_embedded, $this->_embedded->children)) 
        {
            return ResourceFactory::createBaseResourceCollection(
                $this->client, 
                Category::class,
                $this->_embedded->children
            );
        }

        return $this->client->commerce->categories->all([
            'filter' => [
                'parent' => $this->id
            ]
        ]);
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
     * Get the routes for this category.
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