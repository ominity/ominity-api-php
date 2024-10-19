<?php

namespace Ominity\Api\Resources\Modules\Blog;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
use Ominity\Api\Resources\ResourceFactory;

class Category extends BaseResource
{
    /**
     * Always 'blog_category'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the blog category.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the blog category.
     *
     * @var string
     */
    public $name;

    /**
     * Description of the blog category.
     *
     * @var string
     */
    public $description;

    /**
     * Slug of the blog post.
     *
     * @var string
     */
    public $slug;

    /**
     * Parent Category ID of the blog category.
     *
     * @var int
     */
    public $parentId;
    
    /**
     * Is this category visible?
     *
     * @var bool
     */
    public $isVisible;

    /**
     * Get list of all routes for this blog category. 
     * It has a locale as key and the route as value.
     *
     * @var \stdClass
     */
    public $routes;
    
    /** 
     * UTC datetime the blog category was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the blog category was created in ISO-8601 format.
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
     * Get the route for a specific locale
     * 
     * @param string $locale
     * @return Route|null
     */
    public function getRoute($locale) {
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