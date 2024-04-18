<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class Component extends BaseResource
{
    /**
     * Always 'component'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the component.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the component.
     *
     * @var string
     */
    public $name;

    /**
     * Icon of the component.
     *
     * @var string
     */
    public $icon;

    /**
     * The component fields.
     *
     * @var array|object[]
     */
    public $fields;

    /** 
     * UTC datetime the component was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the component was created in ISO-8601 format.
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
     * Get the fields value objects
     *
     * @return ComponentFieldCollection
     */
    public function fields()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            ComponentField::class,
            $this->fields
        );
    }
}