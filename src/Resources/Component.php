<?php

namespace Ominity\Api\Resources;

class Component extends BaseResource
{
    /**
     * Always 'component'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the field.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * The component fields are the configurable fields for a component.
     *
     * @var array|object[]
     */
    public $fields;

    /** 
     * UTC datetime the page was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the page was created in ISO-8601 format.
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