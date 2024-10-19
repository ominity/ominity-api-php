<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class Page extends BaseResource
{
    /**
     * Always 'page'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the page.
     *
     * @var int
     */
    public $id;

    /**
     * Internal name of the page.
     *
     * @var string
     */
    public $name;

    /**
     * Slug of the page.
     *
     * @var string
     */
    public $slug;

    /**
     * Page meta data for SEO puposes.
     *
     * @var \stdClass
     */
    public $meta;

    /**
     * Get list of all routes for this page. 
     * It has a locale as key and the route as value.
     *
     * @var \stdClass
     */
    public $routes;

    /**
     * The ID of the layout for this page.
     *
     * @var int
     */
    public $layoutId;

    /**
     * @var bool
     */
    public $isCached;

    /**
     * Render friendly page components, only returned if explicit asked in request (include = content).
     *
     * @var array|object[]|null
     */
    public $content;

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
     * @return Layout
     * @throws ApiException
     */
    public function layout() 
    {
        return $this->client->cms->layouts->get($this->layoutId);
    }

     /**
     * Get all page components for this page
     *
     * @return PageComponentCollection
     * @throws ApiException
     */
    public function components() 
    {
        return $this->client->cms->pageComponents->listFor($this);
    }

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