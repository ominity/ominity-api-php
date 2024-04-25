<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseResource;

class Country extends BaseResource
{
    /**
     * Always 'country'
     *
     * @var string
     */
    public $resource;

    /**
     * ISO 3166-1 alpha-2 country code.
     *
     * @var string
     */
    public $code;

    /**
     * Enlgish name of the country.
     *
     * @var string
     */
    public $name;

    /**
     * ISO 639-1 code of the default language for the country.
     *
     * @var string|null
     */
    public $language;

    /**
     * ID of the default currency for the country.
     *
     * @var int|null
     */
    public $currencyId;

    /**
     * Is the country active within commerce?
     *
     * @var bool
     */
    public $isEnabled;

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

    /**
     * @return Language
     * @throws ApiException
     */
    public function language() 
    {
        $languages = $this->client->settings->languages->all([
            'filter' => [
                'active' => true
            ]
        ]);

        if($this->language !== null) {
            $language = $languages->get($this->language);
            if($language) {
                return $language;
            }
        }

        return $languages->getDefault();
    }
}