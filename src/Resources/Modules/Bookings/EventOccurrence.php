<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class EventOccurrence extends BaseResource
{
    /**
     * Always 'bookings_event_occurence'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the event occurrence.
     *
     * @var string
     */
    public $id;

    /**
     * Id of the event.
     *
     * @var int
     */
    public $eventId;

    /**
     * Id of the location where the occurrence is held.
     *
     * @var int
     */
    public $locationId;

    /**
     * Status of the event occurrence.
     *
     * @var string
     */
    public $status;

    /** 
     * UTC datetime the event occurrence starts in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $startAt;

    /** 
     * UTC datetime the event occurrence ends in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $endAt;

    /**
     * Contains the bookings statistics for the event occurrence,
     * including the current number of bookings and the maximum number of bookings.
     * 
     * @var \stdClass
     */
    public $bookings;

    /**
     * Contains the participants statistics for the event occurrence,
     * including the current number of participants and the maximum number of participants.
     * 
     * @var \stdClass
     */
    public $participants;

    /** 
     * UTC datetime the event was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the event was created in ISO-8601 format.
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
     * Get the event related to this event occurrence.
     *
     * @return Event
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function event()
    {
        if (isset($this->_embedded, $this->_embedded->event)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->event,
                new Event($this->client)
            );
        }

        return $this->client->modules->bookings->events->get($this->eventId);
    }

    /**
     * Get the location where the event occurrence is held.
     * 
     * @return Location
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function location()
    {
        if (isset($this->_embedded, $this->_embedded->location)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->location,
                new Location($this->client)
            );
        }

        return $this->client->modules->bookings->locations->get($this->locationId);
    }
}