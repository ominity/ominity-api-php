<?php

namespace Ominity\Api\Resources\Modules\Blog;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
use Ominity\Api\Resources\ResourceFactory;

class Tag extends BaseResource
{
    /**
     * Always 'blog_tag'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the blog tag.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the blog tag.
     *
     * @var string
     */
    public $name;

    /**
     * Slug of the blog tag.
     *
     * @var string
     */
    public $slug;
    
    /**
     * Is this tag visible?
     *
     * @var bool
     */
    public $isVisible;

    /**
     * Get list of all routes for this blog tag. 
     * It has a locale as key and the route as value.
     *
     * @var \stdClass
     */
    public $routes;
    
    /** 
     * UTC datetime the blog tag was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the blog tag was created in ISO-8601 format.
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
     * Get the routes for this tag.
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