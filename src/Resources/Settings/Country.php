<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Commerce\Currency;
use Ominity\Api\Resources\ResourceFactory;

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
     * ISO 4217 currency code of the country.
     *
     * @var string
     */
    public $currency;

    /**
     * Is the country active within commerce?
     *
     * @var bool
     */
    public $isEnabled;

    /** 
     * UTC datetime the country was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the country was created in ISO-8601 format.
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
     * Retrieve the currency for the country.
     *
     * @return Currency
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function currency()
    {
        if (isset($this->_embedded, $this->_embedded->currency)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->currency,
                new Currency($this->client)
            );
        }
        
        return $this->client->commerce->currencies->get($this->currency);
    }

    /**
     * Retrieve the language for the country.
     * 
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