<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Resources\Settings\Country;

class Address extends BaseResource
{
    /**
     * Always 'address'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the address.
     *
     * @var int
     */
    public $id;

    /**
     * Customer ID of the address.
     *
     * @var int
     */
    public $customerId;

    /**
     * Contact first name of the address.
     *
     * @var string|null
     */
    public $firstName;

    /**
     * Contact last name of the address.
     *
     * @var string|null
     */
    public $lastName;

    /**
     * Street of the address.
     *
     * @var string
     */
    public $street;

    /**
     * Number of the address.
     *
     * @var string
     */
    public $number;

    /**
     * Additional of the address.
     *
     * @var string
     */
    public $additional;

    /**
     * Postal code of the address.
     *
     * @var string
     */
    public $postalCode;
    
    /**
     * City of the address.
     *
     * @var string
     */
    public $city;

    /**
     * Regio of the address.
     *
     * @var string
     */
    public $region;

    /**
     * Country of the address in ISO 3166-1 alpha-2 format.
     *
     * @var string
     */
    public $country;

    /** 
     * UTC datetime the address was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the address was created in ISO-8601 format.
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
     * Is the address valid?
     *
     * @return bool
     */
    public function isValid()
    {
        return !empty($this->firstName) && !empty($this->lastName) && !empty($this->street) && !empty($this->number) && !empty($this->postalCode) && !empty($this->city) && !empty($this->country);
    }

    /**
     * Get country
     * 
     * @return Country|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function country() {
        if (! isset($this->country)) {
            return null;
        }

        return $this->client->settings->countries->get($this->country);
    }

    /**
     * Saves the address's updated details.
     *
     * @return Address
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "street" => $this->street,
            "number" => $this->number,
            "additional" => $this->additional,
            "postalCode" => $this->postalCode,
            "city" => $this->city,
            "region" => $this->region,
            "country" => $this->country,
        ];

        $result = $this->client->commerce->customers->addresses->updateForId($this->customerId, $this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Address($this->client));
    }

    /**
     * Deletes the address.
     *
     * @return mixed
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function delete()
    {
        $this->client->commerce->customers->addresses->deleteForId($this->customerId, $this->id);
    }
}