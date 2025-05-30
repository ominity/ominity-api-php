<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Resources\Users\User;

class CustomerUser extends BaseResource
{
    /**
     * Always 'customer_user'
     *
     * @var string
     */
    public $resource;

    /**
     * ID of the user.
     *
     * @var int
     */
    public $userId;

    /**
     * ID of the customer.
     *
     * @var int
     */
    public $customerId;

    /**
     * Role ID of the role.
     *
     * @var int
     */
    public $roleId;

    /**
     * First name of the user.
     *
     * @var string
     */
    public $firstName;

    /**
     * Last name of the user.
     *
     * @var string
     */
    public $lastName;

    /**
     * Emailaddress of the user.
     *
     * @var string
     */
    public $email;

    /**
     * Avatar of the user.
     *
     * @var string
     */
    public $avatar;

    /** 
     * UTC datetime the customer user was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the customer user was created in ISO-8601 format.
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
     * Get the User
     * 
     * @return User
     * @throws ApiException
     */
    public function user() {
        if (isset($this->_embedded, $this->_embedded->user)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->user,
                new User($this->client)
            );
        }

        return $this->client->users->get($this->userId);
    }

    /**
     * Get the Customer
     * 
     * @return Customer
     * @throws ApiException
     */
    public function customer() {
        if (isset($this->_embedded, $this->_embedded->customer)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->customer,
                new Customer($this->client)
            );
        }

        return $this->client->commerce->customers->get($this->customerId);
    }
}