<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Commerce\Order;
use Ominity\Api\Resources\Commerce\OrderLine;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\Modules\Bookings\BookingStatus;

class Booking extends BaseResource
{
    /**
     * Always 'bookings_booking'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the booking.
     *
     * @var int
     */
    public $id;

    /**
     * The booking number.
     *
     * @var string
     */
    public $number;

    /**
     * The ID of the order this booking belongs to.
     *
     * @var int
     */
    public $orderId;

    /**
     * The ID of the order item this booking belongs to.
     *
     * @var int
     */
    public $orderLineId;

    /**
     * The ID of the customer this booking belongs to.
     *
     * @var int|null
     */
    public $customerId;

    /**
     * The ID of the event this booking belongs to.
     *
     * @var string
     */
    public $eventId;

    /**
     * The ID of the event occurrence this booking belongs to.
     *
     * @var string
     */
    public $eventOccurenceId;

    /**
     * Status of the booking.
     *
     * @var string
     */
    public $status;

    /**
     * The number of participants in this booking.
     *
     * @var int
     */
    public $participantsCount;

    /**
     * The custom fields of the booking.
     *
     * @var \stdClass
     */
    public $customFields;

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
     * Get the order related to this booking.
     *
     * @return Order
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function order()
    {
        if (isset($this->_embedded, $this->_embedded->order)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->order,
                new Order($this->client)
            );
        }
        
        return $this->client->commerce->orders->get($this->orderId);
    }

    /**
     * Get the order line related to this booking.
     *
     * @return OrderLine
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function orderLine()
    {
        return $this->order()->lines()->get($this->orderLineId);
    }
    
    /**
     * Get the event occurrence related to this booking.
     *
     * @return EventOccurrence
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function eventOccurence()
    {
        if (isset($this->_embedded, $this->_embedded->event_occurrence)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->event_occurrence,
                new EventOccurrence($this->client)
            );
        }
        
        return $this->client->modules->bookings->events->occurrences->getForId($this->eventId, $this->eventOccurenceId);
    }

    /**
     * Get the participants related to this booking.
     *
     * @return ParticipantCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function participants()
    {
        if (isset($this->_embedded, $this->_embedded->participants)) 
        {
            return ResourceFactory::createBaseResourceCollection(
                $this->client, 
                Participant::class,
                $this->_embedded->participants
            );
        }
        
        return $this->client->modules->bookings->participants->listForId($this->id);
    }

    /**
     * Is this booking still pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === BookingStatus::PENDING;
    }

    /**
     * Is this booking confirmed?
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->status === BookingStatus::CONFIRMED;
    }

    /**
     * Is this booking cancelled?
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === BookingStatus::CANCELLED;
    }

    /**
     * Is this booking completed?
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === BookingStatus::COMPLETED;
    }

    /**
     * Is this booking a no-show?
     *
     * @return bool
     */
    public function isNoShow()
    {
        return $this->status === BookingStatus::NO_SHOW;
    }

    /**
     * Is this booking pending reschedule?
     *
     * @return bool
     */
    public function isPendingReschedule()
    {
        return $this->status === BookingStatus::PENDING_RESCHEDULE;
    }

    /**
     * Is this booking rescheduled?
     *
     * @return bool
     */
    public function isRescheduled()
    {
        return $this->status === BookingStatus::RESCHEDULED;
    }

    /**
     * Saves the bookings's updated details.
     *
     * @return Booking
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "customerId" => $this->customerId,
            "eventOccurenceId" => $this->eventOccurenceId,
            "status" => $this->status,
            "customFields" => $this->customFields
        ];

        return $this->client->modules->bookings->update($this->id, $body);
    }
}