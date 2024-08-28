<?php

namespace Ominity\Api\Endpoints\Modules\Bookings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Modules\Bookings\Event;
use Ominity\Api\Resources\Modules\Bookings\EventCollection;

class EventEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "modules/bookings/events";

    /**
     * RESTful EventOccurrence resource.
     *
     * @var EventOccurrenceEndpoint
     */
    public EventOccurrenceEndpoint $occurrences;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);
        
        $this->occurrences = new EventOccurrenceEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Event($this->client);
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
        return new EventCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an Event from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param int $eventId
     * @param array $parameters
     *
     * @return Event
     * @throws ApiException
     */
    public function get($eventId, array $parameters = [])
    {
        return $this->rest_read($eventId, $parameters);
    }

    /**
     * Retrieves a collection of Events from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return EventCollection
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
     * @return EventCollection
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