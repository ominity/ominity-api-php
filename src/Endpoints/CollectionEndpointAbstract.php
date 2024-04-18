<?php

namespace Ominity\Api\Endpoints;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\BaseCollection;
use Ominity\Api\Resources\CursorCollection;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\ResourceFactory;

abstract class CollectionEndpointAbstract extends EndpointAbstract
{
    /**
     * Get a collection of objects from the REST API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $filters
     *
     * @return mixed
     * @throws ApiException
     */
    protected function rest_list(?string $page = null, ?int $limit = null, array $filters = [])
    {
        $filters = array_merge(["page" => $page, "limit" => $limit], $filters);

        $apiPath = $this->getResourcePath() . $this->buildQueryString($filters);

        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);

        /** @var BaseCollection $collection */
        $collection = $this->getResourceCollectionObject($result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * Create a generator for iterating over a resource's collection using REST API calls.
     *
     * This function fetches paginated data from a RESTful resource endpoint and returns a generator
     * that allows you to iterate through the items in the collection one by one. It supports forward
     * and backward iteration, pagination, and filtering.
     *
     * @param string $page The first resource ID you want to include in your list.
     * @param int $limit
     * @param array $filters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     * @return LazyCollection
     */
    protected function rest_iterator(?string $page = null, ?int $limit = null, array $filters = [], bool $iterateBackwards = false): LazyCollection
    {
        /** @var CursorCollection $collection */
        $collection = $this->rest_list($page, $limit, $filters);

        return $collection->getAutoIterator($iterateBackwards);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return BaseCollection
     */
    abstract protected function getResourceCollectionObject($count, $_links);
}