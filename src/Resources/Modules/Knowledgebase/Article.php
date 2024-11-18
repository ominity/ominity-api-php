<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Cms\Route;
use Ominity\Api\Resources\Cms\RouteCollection;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\Modules\Knowledgebase\ArticleStatus;
use Ominity\Api\Types\Modules\Knowledgebase\ArticleVisibility;

class Article extends BaseResource
{
    /**
     * Always 'knowledgebase_article'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the knowledge base article.
     *
     * @var int
     */
    public $id;

    /**
     * Title of the knowledge base article.
     *
     * @var string
     */
    public $title;

    /**
     * Status of the knowledge base article.
     *
     * @var string
     */
    public $status;

    /**
     * Visbility of the knowledge base article.
     *
     * @var string
     */
    public $visbility;

    /**
     * Content of the knowledge base article.
     *
     * @var string
     */
    public $content;

    /**
     * Slug of the knowledge base article.
     *
     * @var string
     */
    public $slug;

    /**
     * Category ID of the knowledge base article.
     *
     * @var int|null
     */
    public $categoryId;
    
    /**
     * Author ID of the knowledge base article.
     *
     * @var int|null
     */
    public $authorId;

    /**
     * Time to read the knowledge base article in minutes.
     *
     * @var int
     */
    public $timeToRead;

    /**
     * Order of the knowledge base article.
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
     * Get list of all routes for this knowledge base article.
     * It has a locale as key and the route as value.
     *
     * @var \stdClass
     */
    public $routes;

    /**
     * List of searchables for this knowledge base article.
     *
     * @var array|string[]
     */
    public $searches;

    /**
     * List of tags related to the knowledge base article.
     *
     * @var array|\stdClass[]
     */
    public $tags;

    /**
     * Custom field values of the knowledge base article.
     *
     * @var \stdClass
     */
    public $customFields;
    
    /** 
     * UTC datetime the knowledge base article was published in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $publishedAt;

    /** 
     * UTC datetime the knowledge base article was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the knowledge base article was created in ISO-8601 format.
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
     * Is this article a draft?
     * 
     * @return bool
     */
    public function isDraft() {
        return $this->status === ArticleStatus::DRAFT;
    }

    /**
     * Is this article scheduled?
     * 
     * @return bool
     */
    public function isScheduled() {
        return $this->status === ArticleStatus::SCHEDULED;
    }

    /**
     * Is this article published?
     * 
     * @return bool
     */
    public function isPublished() {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    /**
     * Is this article archived?
     * 
     * @return bool
     */
    public function isArchived() {
        return $this->status === ArticleStatus::ARCHIVED;
    }

    /**
     * Is this article's visibility private?
     * 
     * @return bool
     */
    public function isPrivate() {
        return $this->visbility === ArticleVisibility::PRIVATE;
    }

    /**
     * Is this article's visibility users?
     * 
     * @return bool
     */
    public function isUsers() {
        return $this->visbility === ArticleVisibility::USERS;
    }

    /**
     * Is this article's visibility public?
     * 
     * @return bool
     */
    public function isPublic() {
        return $this->visbility === ArticleVisibility::PUBLIC;
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
     * Get the routes for this article.
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
        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $this->tags ?? [],
            Tag::class
        );
    }

    /**
     * Get the category related to this blog post.
     *
     * @return ArticleFeedbackCollection
     */
    public function feedbacks()
    {
        if (isset($this->_embedded, $this->_embedded->feedbacks)) 
        {
            return ResourceFactory::createBaseResourceCollection(
                $this->client,
                ArticleFeedback::class,
                $this->_embedded->feedbacks
            );
        }

        return $this->client->modules->knowledgebase->articles->feedbacks->listFor($this);
    }
}