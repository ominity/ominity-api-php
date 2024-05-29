<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;

class VatValidation extends BaseResource
{
    /**
     * Always 'vatvalidation'
     *
     * @var string
     */
    public $resource;

    /**
     * The VAT number that is validated.
     *
     * @var string
     */
    public $vatNumber;

    /**
     * Is this VAT number valid?
     *
     * @var bool
     */
    public $isValid;

    /** 
     * UTC datetime the customer was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the customer was created in ISO-8601 format.
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