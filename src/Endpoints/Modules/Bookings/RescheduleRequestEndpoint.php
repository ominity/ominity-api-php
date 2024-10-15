<?php

namespace Ominity\Api\Endpoints\Modules\Bookings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Modules\Bookings\RescheduleRequest;
use Ominity\Api\Resources\Modules\Bookings\RescheduleRequestCollection;
use Ominity\Api\Resources\ResourceFactory;

class RescheduleRequestEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "modules/bookings/reschedule-requests";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new RescheduleRequest($this->client);
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
        return new RescheduleRequestCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an Reschedule Request from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param int $requestId
     * @param array $parameters
     *
     * @return RescheduleRequest
     * @throws ApiException
     */
    public function get($requestId, array $parameters = [])
    {
        return $this->rest_read($requestId, $parameters);
    }

    /**
     * Retrieve an Reschedule Request from the API by token.
     *
     * Will throw a ApiException if the token is invalid or the resource cannot be found.
     *
     * @param string $token
     * @param array $parameters
     *
     * @return RescheduleRequest
     * @throws ApiException
     */
    public function getByToken($token, array $parameters = [])
    {
        $resource = "{$this->getResourcePath()}/token/" . urlencode($token)  . $this->buildQueryString($parameters);
        
        $result = $this->client->performHttpCall(self::REST_READ, $resource);
        
        return ResourceFactory::createFromApiResult($result, new RescheduleRequest($this->client));
    }

    /**
     * Retrieves a collection of Reschedule Request from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return RescheduleRequestCollection
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
     * @return RescheduleRequestCollection
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