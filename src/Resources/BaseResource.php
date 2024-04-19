<?php

namespace Ominity\Api\Resources;

use Ominity\Api\OminityApiClient;

#[\AllowDynamicProperties]
abstract class BaseResource
{
    /**
     * @var OminityApiClient
     */
    protected $client;

    /**
     * Indicates the type of resource.
     *
     * @example product
     *
     * @var string
     */
    public $resource;

    /**
     * @param OminityApiClient $client
     */
    public function __construct(OminityApiClient $client)
    {
        $this->client = $client;
    }
}