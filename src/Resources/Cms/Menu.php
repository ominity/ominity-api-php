<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;

class Menu extends BaseResource
{
    /**
     * Always 'menu'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the menu.
     *
     * @var int
     */
    public $id;

    /**
     * Internal name of the menu.
     *
     * @var string
     */
    public $name;

    /**
     * Identifier of the menu.
     *
     * @var string
     */
    public $identifier;

    /** 
     * UTC datetime the menu was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the menu was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * When passing the rendered include this will be available.
     * 
     * @var \stdClass|null
     */
    public $rendered;

    /**
     * @var \stdClass
     */
    public $_links;
}