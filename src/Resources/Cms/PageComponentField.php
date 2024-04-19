<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;

class PageComponentField extends BaseResource
{
    /**
     * Always 'page_component_field'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the page component field.
     *
     * @var int
     */
    public $id;

    /**
     * The ID of the page component of this page component field.
     *
     * @var int
     */
    public $pageComponentId;

    /**
     * The ID of the component field of this page component field.
     *
     * @var int
     */
    public $componentFieldId;

    /**
     * Value of the page componet field, can be a string or array of nested page components.
     *
     * @var string|array|object[]
     */
    public $value;

    /** 
     * UTC datetime the page component field was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the page component field was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;
}