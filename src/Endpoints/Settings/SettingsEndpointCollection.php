<?php

namespace Ominity\Api\Endpoints\Settings;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class SettingsEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Language resource.
     *
     * @var LanguageEndpoint
     */
    public $languages;

    public function initializeEndpoints()
    {
        $this->languages = new LanguageEndpoint($this->client);
    }
}