<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class Location extends BaseResource
{
    /**
     * Always 'bookings_location'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the location.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the location.
     *
     * @var string
     */
    public $name;

    /**
     * Type of the location.
     *
     * @var string
     */
    public $type;

    /**
     * Address of the location if location type is PHYSICAL.
     * 
     * @var \stdClass
     */
    public $address;

    /**
     * Parent location ID if this location is a sub-location.
     *
     * @var int|null
     */
    public $parentId;

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
     * Get the parent location.
     *
     * @return Location|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function parent()
    {
        if(!isset($this->parentId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->parent)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->parent,
                new Location($this->client)
            );
        }
        
        return $this->client->modules->forms->forms->fields->listForId($this->id);
    }
}