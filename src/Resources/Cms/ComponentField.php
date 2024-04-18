<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;

class ComponentField extends BaseResource
{
    /**
     * Always 'componentfield'
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
     * Description of the field.
     *
     * @var string
     */
    public $description;

    /**
     * Data type of the field.
     *
     * @var string
     */
    public $type;

    /**
     * Data type varaiant of the field.
     *
     * @var string|null
     */
    public $variant;

    /**
     * Default value of the field.
     *
     * @var string|null
     */
    public $defaultValue;

    /**
     * @var bool
     */
    public $isTranslatable;

    /**
     * Validation rules of this field.
     *
     * @var \stdClass
     */
    public $validation;

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
}