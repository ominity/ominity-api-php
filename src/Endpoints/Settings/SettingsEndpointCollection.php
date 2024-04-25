<?php

namespace Ominity\Api\Endpoints\Settings;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class SettingsEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Country resource.
     *
     * @var CountryEndpoint
     */
    public $countries;

    /**
     * RESTful Language resource.
     *
     * @var LanguageEndpoint
     */
    public $languages;

    public function initializeEndpoints()
    {
        $this->countries = new CountryEndpoint($this->client);
        $this->languages = new LanguageEndpoint($this->client);
    }
}