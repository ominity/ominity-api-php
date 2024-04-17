<?php

namespace Ominity\Api\Endpoints;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Page;
use Ominity\Api\Resources\PageCollection;

class PageEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "cms/pages";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Page($this->client);
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
        return new PageCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an Page from the API.
     *
     * Will throw a ApiException if the invoice id is invalid or the resource cannot be found.
     *
     * @param string $pageId
     * @param array $parameters
     *
     * @return Page
     * @throws ApiException
     */
    public function get($pageId, array $parameters = [])
    {
        return $this->rest_read($pageId, $parameters);
    }

    /**
     * Retrieves a collection of Pages from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return PageCollection
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
     * @return \Ominity\Api\Resources\BaseCollection
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