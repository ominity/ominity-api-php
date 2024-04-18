<?php

namespace Ominity\Api\Endpoints;

use Ominity\Api\OminityApiClient;

abstract class EndpointCollectionAbstract
{
    /**
     * @var OminityApiClient
     */
    protected $client;

    /**
     * @param OminityApiClient $api
     */
    public function __construct(OminityApiClient $api)
    {
        $this->client = $api;
        
        $this->initializeEndpoints();
    }
    
    abstract public function initializeEndpoints();
}