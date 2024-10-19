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
     * Name of the route.
     *
     * @var string
     */
    public $name;

    /**
     * Locale of the route.
     *
     * @var string
     */
    public $locale;

    /**
     * Available parameters of the route.
     *
     * @var \stdClass
     */
    public $parameters;

    /**
     * @var \stdClass
     */
    public $_links;
}