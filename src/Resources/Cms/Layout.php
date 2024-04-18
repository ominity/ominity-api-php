<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;

class Layout extends BaseResource
{
    /**
     * Always 'layout'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the layout.
     *
     * @var int
     */
    public $id;

    /**
     * Internal name of the layout.
     *
     * @var string
     */
    public $name;

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