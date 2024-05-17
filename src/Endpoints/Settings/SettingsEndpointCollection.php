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

    /**
     * RESTful SocialProvider resource.
     *
     * @var SocialProviderEndpoint
     */
    public $socialproviders;

    public function initializeEndpoints()
    {
        $this->countries = new CountryEndpoint($this->client);
        $this->languages = new LanguageEndpoint($this->client);
        $this->socialproviders = new SocialProviderEndpoint($this->client);
    }
}