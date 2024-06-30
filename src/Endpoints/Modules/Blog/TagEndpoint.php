<?php

namespace Ominity\Api\Endpoints\Modules\Blog;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Modules\Blog\Tag;
use Ominity\Api\Resources\Modules\Blog\TagCollection;

class TagEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "modules/blog/tags";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Tag($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Ominity\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new TagCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an blog Tag from the API.
     *
     * Will throw a ApiException if the tag id is invalid or the resource cannot be found.
     *
     * @param int $tagId
     * @param array $parameters
     *
     * @return Tag
     * @throws ApiException
     */
    public function get($tagId, array $parameters = [])
    {
        return $this->rest_read($tagId, $parameters);
    }

    /**
     * Retrieves a collection of blog Tags from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return TagCollection
     * @throws ApiException
     */
    public function page($page = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for page
     *
     * @param array $parameters
     *
     * @return TagCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages retrieved from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $page = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($page, $limit, $parameters, $iterateBackwards);
    }
}