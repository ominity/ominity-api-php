<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class Event extends BaseResource
{
    /**
     * Always 'bookings_event'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the event.
     *
     * @var int
     */
    public $id;

    /**
     * Type of the event.
     *
     * @var string
     */
    public $type;

    /**
     * Id of the location where the event is held.
     *
     * @var int
     */
    public $locationId;

    /**
     * Title of the event.
     *
     * @var string
     */
    public $title;

    /**
     * Description of the event.
     *
     * @var string
     */
    public $description;

    /** 
     * UTC datetime the event starts in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $startAt;

    /** 
     * UTC datetime the event ends in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $endAt;

    /**
     * List of prices for this event with the amount and currency.
     * 
     * @var stdClass[]
     */
    public $prices;

    /**
     * Is this event enabled?
     *
     * @var boolean
     */
    public $isEnabled;

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
     * Get the price for this event in the given currency.
     * 
     * @var float|null
     */
    public function getPrice($currency)
    {
        foreach ($this->prices as $price) {
            if ($price->currency == $currency) {
                return (float) $price->amount;
            }
        }

        return null;
    }

    /**
     * Get the location where the event is held.
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