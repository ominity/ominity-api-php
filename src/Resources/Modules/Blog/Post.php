<?php

namespace Ominity\Api\Resources\Modules\Blog;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\Modules\Blog\PostStatus;

class Post extends BaseResource
{
    /**
     * Always 'blog_post'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the blog post.
     *
     * @var int
     */
    public $id;

    /**
     * Title of the blog post.
     *
     * @var string
     */
    public $title;

    /**
     * Status of the blog post.
     *
     * @var string
     */
    public $status;

    /**
     * Content of the blog post.
     *
     * @var string
     */
    public $content;

    /**
     * Image of the blog post.
     *
     * @var string|null
     */
    public $image;

    /**
     * Slug of the blog post.
     *
     * @var string
     */
    public $slug;

    /**
     * Teaser short description of the blog post.
     *
     * @var string
     */
    public $teaser;

    /**
     * Teaser image of the blog post.
     *
     * @var string|null
     */
    public $teaserImage;

    /**
     * Category ID of the blog post.
     *
     * @var int
     */
    public $categoryId;
    
    /**
     * Publisher ID of the blog post.
     *
     * @var int|null
     */
    public $publisherId;

    /**
     * Time to read the blog post in minutes.
     *
     * @var int
     */
    public $timeToRead;

    /**
     * Meta tags of the blog post.
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
     * UTC datetime the blog post was published in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $publishedAt;

    /** 
     * UTC datetime the blog post was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the blog post was created in ISO-8601 format.
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
     * Is this post a draft?
     * 
     * @return bool
     */
    public function isDraft() {
        return $this->status === PostStatus::DRAFT;
    }

    /**
     * Is this post scheduled?
     * 
     * @return bool
     */
    public function isScheduled() {
        return $this->status === PostStatus::SCHEDULED;
    }

    /**
     * Is this post published?
     * 
     * @return bool
     */
    public function isPublished() {
        return $this->status === PostStatus::PUBLISHED;
    }

    /**
     * Is this post archived?
     * 
     * @return bool
     */
    public function isArchived() {
        return $this->status === PostStatus::ARCHIVED;
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
     * Get the routes for this post.
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
     * Get the category related to this blog post.
     *
     * @return Category
     */
    public function category()
    {
        if (isset($this->_embedded, $this->_embedded->category)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->category,
                new Category($this->client)
            );
        }

        return $this->client->modules->blog->categories->get($this->categoryId);
    }

    /**
     * Get tags related to this blog post.
     *
     * @return TagCollection
     */
    public function tags()
    {
        if (isset($this->_embedded, $this->_embedded->tags)) 
        {
            return ResourceFactory::createCursorResourceCollection(
                $this->client,
                $this->_embedded->tags,
                Tag::class
            );
        }

        return null;
    }
}