<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\CustomerType;

class Customer extends BaseResource
{
    /**
     * Always 'customer'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the customer.
     *
     * @var int
     */
    public $id;

    /**
     * Owner user ID of the customer.
     *
     * @var int
     */
    public $ownerId;

    /**
     * Type of the customer.
     *
     * @var string|CustomerType
     */
    public $type;

    /**
     * Company name of the customer.
     *
     * @var string|null
     */
    public $companyName;

    /**
     * Vat number of the customer.
     *
     * @var string|null
     */
    public $companyVat;

    /**
     * Phone number of the customer.
     *
     * @var string
     */
    public $phone;

    /**
     * Default billing address of the customer.
     *
     * @var \stdClass|null
     */
    public $billingAddress;

    /**
     * Default shipping address of the customer.
     *
     * @var \stdClass|null
     */
    public $shippingAddress;

    /** 
     * UTC datetime the customer was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the customer was created in ISO-8601 format.
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
     * Is this a private customer?
     *
     * @return bool
     */
    public function isPrivate() {
        return $this->type === CustomerType::PRIVATE;
    }

    /**
     * Is this a business customer?
     *
     * @return bool
     */
    public function isBusiness() {
        return $this->type === CustomerType::BUSINESS;
    }

    /**
     * Get billing address
     * 
     * @return Address|null
     */
    public function billingAddress() {
        if (! isset($this->billingAddress)) {
            return null;
        }

        return ResourceFactory::createFromApiResult(
            $this->billingAddress, 
            new Address($this->client)
        );
    }

    /**
     * Get shipping address
     * 
     * @return Address|null
     */
    public function shippingAddress() {
        if (! isset($this->billingAddress)) {
            return null;
        }

        return ResourceFactory::createFromApiResult(
            $this->shippingAddress, 
            new Address($this->client)
        );
    }

    /**
     * Get shipping address
     * 
     * @return User
     * @throws ApiException
     */
    public function owner() {
        return $this->client->users->get($this->ownerId);
    }

    /**
     * Get shipping address
     * 
     * @return CustomerUserCollection
     * @throws ApiException
     */
    public function users() {
        return $this->client->commerce->customers->users->allFor($this);
    }

    /**
     * Saves the user's updated details.
     *
     * @return User
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "type" => $this->type,
            "companyName" => $this->companyName,
            "companyVat" => $this->companyVat,
            "phone" => $this->phone,
            "ownerId" => $this->ownerId,
        ];

        $result = $this->client->commerce->customers->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Customer($this->client));
    }
}