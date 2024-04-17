<?php

namespace Ominity\Api\Resources;

class Route extends BaseResource
{
    /**
     * Id of the route.
     *
     * @var string
     */
    public $id;

    /**
     * Type of the route.
     * @var string
     */
    public $type;

    /**
     * Amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * The destination where the routed payment was sent.
     *
     * @var \stdClass
     */
    public $destination;

    /**
     * A UTC date. The settlement of a routed payment can be delayed on payment level, by specifying a release Date
     *
     * @example "2013-12-25"
     * @var string
     */
    public $releaseDate;
}