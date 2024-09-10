<?php

namespace Ominity\Api\Endpoints\Modules\Bookings;


use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Modules\Bookings\Booking;
use Ominity\Api\Resources\Modules\Bookings\Participant;
use Ominity\Api\Resources\Modules\Bookings\ParticipantCollection;

class ParticipantEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "modules/bookings/{bookingId}/participants";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ParticipantCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new Participant($this->client);
    }

    /**
     * Update an participant for a specific Booking.
     *
     * @param Booking $booking
     * @param int $participantId
     * @param array $data
     *
     * @return Participant
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function updateFor(Booking $booking, int $participantId, array $data)
    {
        return $this->updateForId($booking->id, $participantId, $data);
    }

    /**
     * Update an participant for a specific Booking ID.
     *
     * @param int $bookingId
     * @param int $participantId
     * @param array $data
     *
     * @return Participant
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function updateForId($bookingId, int $participantId, array $data)
    {
        $this->setPathVariables(['bookingId' => $bookingId]);

        return parent::rest_update($participantId, $data);
    }

    /**
     * Get the participant for a specific Booking.
     *
     * @param Booking $booking
     * @param int $participantId
     * @return Participant
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Booking $booking, int $participantId, array $parameters = []) {
        if (empty($booking)) {
            throw new ApiException("Booking is empty.");
        }

        if (empty($participantId)) {
            throw new ApiException("Participant ID is empty.");
        }

        return $this->getForId($booking->id, $participantId, $parameters);
    }

    /**
     * Get the participant for a specific Booking ID.
     *
     * @param int $bookingId
     * @param int $participantId
     * @return Participant
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $bookingId, int $participantId, array $parameters = []) {
        if (empty($bookingId)) {
            throw new ApiException("Booking ID is empty.");
        }

        if (empty($participantId)) {
            throw new ApiException("Participant ID is empty.");
        }

        $this->setPathVariables(['bookingId' => $bookingId]);
        return parent::rest_read($participantId, $parameters);
    }

    /**
     * List the participants for a specific Booking.
     *
     * @param Booking $booking
     * @param array $parameters
     * @return ParticipantCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Booking $booking, array $parameters = [])
    {
        return $this->listForId($booking->id, $parameters);
    }

    /**
     * List the participants for a specific Booking ID.
     *
     * @param string $bookingId
     * @param array $parameters
     * @return ParticipantCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $bookingId, array $parameters = [])
    {
        $this->setPathVariables(['bookingId' => $bookingId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over participants for the given booking retrieved from Ominity.
     *
     * @param Booking $booking
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Booking $booking, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($booking->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over participants for the given booking id retrieved from Ominity.
     *
     * @param int $bookingId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $bookingId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['bookingId' => $bookingId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}