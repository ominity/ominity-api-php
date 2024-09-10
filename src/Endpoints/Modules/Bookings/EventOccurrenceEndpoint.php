<?php

namespace Ominity\Api\Endpoints\Modules\Bookings;


use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Modules\Bookings\Event;
use Ominity\Api\Resources\Modules\Bookings\EventOccurrenceCollection;
use Ominity\Api\Resources\Modules\Bookings\EventOccurrence;

class EventOccurrenceEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "modules/bookings/events/{eventId}/occurrences";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new EventOccurrenceCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new EventOccurrence($this->client);
    }

    /**
     * Get the event occurrence for a specific Event.
     *
     * @param Event $event
     * @param string $occurrenceId
     * @return EventOccurrence
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Event $event, string $occurrenceId, array $parameters = []) {
        if (empty($event)) {
            throw new ApiException("Event is empty.");
        }

        if (empty($occurrenceId)) {
            throw new ApiException("Occurrence ID is empty.");
        }

        return $this->getForId($event->id, $occurrenceId, $parameters);
    }

    /**
     * Get the event occurrence for a specific Event ID.
     *
     * @param int $eventId
     * @param string $occurrenceId
     * @return EventOccurrence
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $eventId, string $occurrenceId, array $parameters = []) {
        if (empty($eventId)) {
            throw new ApiException("Event ID is empty.");
        }

        if (empty($occurrenceId)) {
            throw new ApiException("Occurrence ID is empty.");
        }

        $this->setPathVariables(['eventId' => $eventId]);
        return parent::rest_read($occurrenceId, $parameters);
    }

    /**
     * List the occurrences for a specific Event.
     *
     * @param Event $event
     * @param array $parameters
     * @return EventOccurrenceCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Event $event, array $parameters = [])
    {
        return $this->listForId($event->id, $parameters);
    }

    /**
     * List the occurrences for a specific Event ID.
     *
     * @param string $eventId
     * @param array $parameters
     * @return EventOccurrenceCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $eventId, array $parameters = [])
    {
        $this->setPathVariables(['eventId' => $eventId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over event occurrences for the given event retrieved from Ominity.
     *
     * @param Event $event
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Event $event, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($event->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over event occurrences for the given event id retrieved from Ominity.
     *
     * @param int $eventId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $eventId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['eventId' => $eventId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}