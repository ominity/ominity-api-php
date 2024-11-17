<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
use Ominity\Api\Resources\ResourceFactory;

class Category extends BaseResource
{
    /**
     * Always 'knowledgebase_category'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the knowledge base category.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the knowledge base category.
     *
     * @var string
     */
    public $name;

    /**
     * Description of the knowledge base category.
     *
     * @var string
     */
    public $description;

    /**
     * Icon of the knowledge base category.
     *
     * @var string
     */
    public $icon;

    /**
     * Slug of the knowledge base category.
     *
     * @var string
     */
    public $slug;

    /**
     * Parent Category ID of the knowledge base category.
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
     * Order of the knowledge base category.
     *
     * @var int
     */
    public $order;

    /**
     * Meta tags of the knowledge base article.
     * 
     * @var \stdClass
     */
    public $meta;

    /**
     * Get list of all routes for this knowledge base category. 
     * It has a locale as key and the route as value.
     *
     * @var \stdClass
     */
    public $routes;

    /**
     * Count of articles in this category.
     *
     * @var int
     */
    public $articlesCount;

    /**
     * Count of children categories.
     *
     * @var int
     */
    public $childrenCount;

    /**
     * Custom field values of the knowledge base category.
     *
     * @var \stdClass
     */
    public $customFields;

    /** 
     * UTC datetime the knowledge base category was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the knowledge base category was created in ISO-8601 format.
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

    /**
     * Get the parent category of this category.
     *
     * @return Category|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function parent()
    {
        if (empty($this->parentId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->parent)) {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->parent,
                new Category($this->client)
            );
        }

        // return $this->client->commerce->categories->get($this->parentId);
    }

    /**
     * Get the children categories of this category.
     *
     * @return CategoryCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function children()
    {
        if (isset($this->_embedded, $this->_embedded->children)) {
            return ResourceFactory::createCursorResourceCollection(
                $this->client,
                $this->_embedded->children,
                new Category($this->client)
            );
        }

        return $this->client->modules->knowledgebase->categories->all([
            'filter' => [
                'parent' => $this->id
            ]
        ]);
    }

    /**
     * Get the ancestors of this category.
     *
     * @return CategoryCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function ancestors()
    {
        if (isset($this->_embedded, $this->_embedded->ancestors)) {
            return ResourceFactory::createCursorResourceCollection(
                $this->client,
                $this->_embedded->ancestors,
                new Category($this->client)
            );
        }

        $ancestors = [];
        $category = $this;
        while ($category = $category->parent()) {
            $ancestors[] = $category;
        }

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $ancestors,
            new Category($this->client)
        );
    }
}
