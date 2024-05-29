<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Resources\Users\User;
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
     * Is this customer exempt from taxes?
     *
     * @var bool
     */
    public $isTaxExempt;

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
     * Get all addresses for the customer
     * 
     * @param  array $parameters
     * @return AddressCollection
     * @throws ApiException
     */
    public function addresses($parameters = []) {
        if ( isset($this->_embedded->addresses)) {
            return ResourceFactory::createBaseResourceCollection(
                $this->client,
                Address::class,
                $this->_embedded->addresses
            );
        }

        return $this->client->commerce->customers->addresses->listFor($this, $parameters);
    }

    /**
     * Get all mandates for the customer
     * 
     * @param  array $parameters
     * @return MandateCollection
     * @throws ApiException
     */
    public function mandates($parameters = []) {
        if ( isset($this->_embedded->mandates)) {
            return ResourceFactory::createBaseResourceCollection(
                $this->client,
                Mandate::class,
                $this->_embedded->mandates
            );
        }

        return $this->client->commerce->customers->mandates->allFor($this, $parameters);
    }

    /**
     * Get all orders for the customer
     * 
     * @param  array $parameters
     * @return OrderCollection
     * @throws ApiException
     */
    public function orders($parameters = []) {
        if ( isset($this->_embedded->orders)) {
            return ResourceFactory::createBaseResourceCollection(
                $this->client,
                Order::class,
                $this->_embedded->orders
            );
        }

        return $this->client->commerce->customers->orders->allFor($this, $parameters);
    }

    /**
     * Get all invoices for the customer
     * 
     * @param  array $parameters
     * @return InvoiceCollection
     * @throws ApiException
     */
    public function invoices($parameters = []) {
        if ( isset($this->_embedded->invoices)) {
            return ResourceFactory::createBaseResourceCollection(
                $this->client,
                Invoice::class,
                $this->_embedded->invoices
            );
        }

        return $this->client->commerce->customers->invoices->allFor($this, $parameters);
    }

    /**
     * Get shipping address
     * 
     * @return User
     * @throws ApiException
     */
    public function owner() {
        if(isset($this->_embedded->users)) {
            foreach($this->_embedded->users as $user) {
                if($user->id == $this->ownerId) {
                    return ResourceFactory::createFromApiResult($user, new User($this->client));
                }
            }
        }
        
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