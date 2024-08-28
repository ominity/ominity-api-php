<?php

namespace Ominity\Api\Endpoints\Modules\Bookings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Modules\Bookings\Booking;
use Ominity\Api\Resources\Modules\Bookings\BookingCollection;

class BookingEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "modules/bookings";

    /**
     * RESTful Event resource.
     *
     * @var CalendarEndpoint
     */
    public CalendarEndpoint $calendar;

    /**
     * RESTful Event resource.
     *
     * @var EventEndpoint
     */
    public EventEndpoint $events;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);

        $this->calendar = new CalendarEndpoint($client);
        $this->events = new EventEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Booking($this->client);
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
        return new BookingCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve an Booking from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param int $bookingId
     * @param array $parameters
     *
     * @return Booking
     * @throws ApiException
     */
    public function get($bookingId, array $parameters = [])
    {
        return $this->rest_read($bookingId, $parameters);
    }

    /**
     * Retrieves a collection of Bookings from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return BookingCollection
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
     * @return BookingCollection
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