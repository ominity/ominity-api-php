<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\Modules\Bookings\RescheduleRequestStatus;

class RescheduleRequest extends BaseResource
{
    /**
     * Always 'bookings_reschedule_request'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the booking reschedule request.
     *
     * @var int
     */
    public $id;

    /**
     * Status of the booking reschedule request.
     *
     * @var string
     */
    public $status;

    /**
     * The ID of the booking this reschedule request belongs to.
     *
     * @var int
     */
    public $oldBookingId;

    /**
     * The ID of the new booking created by this reschedule request.
     *
     * @var int
     */
    public $newBookingId;

    /**
     * The reason for the reschedule request.
     *
     * @var string
     */
    public $reason;

    /**
     * The token used to authenticate the reschedule request.
     *
     * @var string
     */
    public $token;

    /** 
     * UTC datetime the token expires in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $tokenExpiresAt;

    /** 
     * UTC datetime the reschedule request was completed in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $completedAt;

    /** 
     * UTC datetime the reschedule request was cancelled in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $cancelledAt;
    
    /** 
     * UTC datetime the reschedule request was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the reschedule request was created in ISO-8601 format.
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
     * Get the old booking to this reschedule request.
     *
     * @return Booking
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function oldBooking()
    {
        if (isset($this->_embedded, $this->_embedded->old_booking)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->old_booking,
                new Booking($this->client)
            );
        }
        
        return $this->client->modules->bookings->get($this->oldBookingId);
    }

    /**
     * Get the new booking to this reschedule request.
     *
     * @return Booking|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function newBooking()
    {
        if($this->newBookingId === null)
        {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->new_booking)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->new_booking,
                new Booking($this->client)
            );
        }
        
        return $this->client->modules->bookings->get($this->newBookingId);
    }

    /**
     * Is this reschedule request still pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === RescheduleRequestStatus::PENDING;
    }

    /**
     * Is this reschedule request confirmed?
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === RescheduleRequestStatus::COMPLETED;
    }

    /**
     * Is this reschedule request cancelled?
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === RescheduleRequestStatus::CANCELLED;
    }

    /**
     * Is this reschedule request completed?
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->status === RescheduleRequestStatus::EXPIRED;
    }

    /**
     * Get the link to the reschedule request.
     *
     * @return string|null
     */
    public function getLink()
    {
        if(isset($this->_links, $this->_links->link))
        {
            return $this->_links->link->href;
        }
    }
}