<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;

class Route extends BaseResource
{
    /**
     * Always 'route'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the route.
     *
     * @var int
     */
    public $id;

    /**
     * Related object type.
     *
     * @var string
     */
    public $relation;

    /**
     * Identifier of the related object.
     *
     * @var string|int
     */
    public $relationId;

    /**
     * List of slugs for all available locales.
     *
     * @var \stdClass
     */
    public $slugs;

    /**
     * @var \stdClass
     */
    public $_links;
}