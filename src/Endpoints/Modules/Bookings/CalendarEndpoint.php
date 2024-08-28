<?php

namespace Ominity\Api\Endpoints\Modules\Bookings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Resources\Modules\Bookings\CalendarCollection;
use Ominity\Api\Resources\Modules\Bookings\EventOccurrence;

class CalendarEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "modules/bookings/calendar";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new EventOccurrence($this->client);
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
        return new CalendarCollection($this->client, $count, $_links);
    }

    /**
     * Retrieve event occurrences from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param string $from Get event occurrences from this date in UTC format
     * @param string $until Get event occurrences until this date in UTC format
     * @param array $parameters
     *
     * @return CalendarCollection
     * @throws ApiException
     */
    public function list($from, $until, array $parameters = [])
    {
        $parameters['from'] = $from;
        $parameters['until'] = $until;

        return $this->rest_list(null, null, $parameters);
    }
}