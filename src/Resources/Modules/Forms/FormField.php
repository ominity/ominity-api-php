<?php

namespace Ominity\Api\Resources\Modules\Forms;

use Ominity\Api\Resources\BaseResource;

class FormField extends BaseResource
{
    /**
     * Always 'form_field'
     *
     * @var string
     */
    public $resource = 'form_field';

    /**
     * Id of the field.
     *
     * @var int
     */
    public $id;

    /**
     * Id of the form.
     *
     * @var int
     */
    public $formId;

    /**
     * Type of the field.
     *
     * @var string
     */
    public $type;

    /**
     * Name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * Label of the field.
     *
     * @var string
     */
    public $label;

    /**
     * Is the label visible?
     *
     * @var bool
     */
    public $isLabelVisible;

    /**
     * Placeholder of the field.
     *
     * @var string
     */
    public $placeholder;

    /**
     * The default value of the field.
     *
     * @var string|null
     */
    public $defaultValue;

    /**
     * Helper of the field.
     *
     * @var string
     */
    public $helper;

    /**
     * Width of the field.
     *
     * @var string|null
     */
    public $width;

    /**
     * Is the field displayed inline?
     *
     * @var bool
     */
    public $isInline;

    /**
     * CSS settings for the field.
     *
     * @var \stdClass
     */
    public $css;

    /**
     * Validation rules for the field.
     *
     * @var \stdClass
     */
    public $validation;

    /**
     * Options for the field (if applicable).
     *
     * @var array|null
     */
    public $options;

    /**
     * Order of the field in the form.
     *
     * @var int
     */
    public $order;

    /** 
     * UTC datetime the field was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the field was created in ISO-8601 format.
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
