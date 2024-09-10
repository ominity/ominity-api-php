<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class Participant extends BaseResource
{
    /**
     * Always 'bookings_participant'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the participant.
     *
     * @var int
     */
    public $id;

    /**
     * The ID of the booking this participant belongs to.
     *
     * @var int
     */
    public $bookingId;

    /**
     * The first name of the participant.
     *
     * @var string|null
     */
    public $firstName;

    /**
     * The last name of the participant.
     *
     * @var string|null
     */
    public $lastName;

    /**
     * The email address of the participant.
     *
     * @var string|null
     */
    public $email;

    /**
     * The phone number of the participant in E.164 format.
     *
     * @var string|null
     */
    public $phone;

    /**
     * The date of birth of the participant.
     *
     * @example "2013-12-25"
     * @var string|null
     */
    public $dateOfBirth;

    /**
     * The address of the participant.
     * 
     * Contains the following properties: 
     * street, number, additional, city, postalCode, region, country
     *
     * @var \stdClass
     */
    public $address;

    /**
     * The custom fields of the participant.
     *
     * @var \stdClass
     */
    public $customFields;

    /** 
     * UTC datetime the participant was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the participant was created in ISO-8601 format.
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
     * Get the Booking related to this participant.
     *
     * @return Booking
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function booking()
    {
        if (isset($this->_embedded, $this->_embedded->booking)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->booking,
                new Booking($this->client)
            );
        }
        
        return $this->client->modules->bookings->get($this->bookingId);
    }
}