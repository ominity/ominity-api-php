<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class User extends BaseResource
{
    /**
     * Always 'user'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the user.
     *
     * @var int
     */
    public $id;

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
     * Preffered language of the user in ISO 639-1 format.
     *
     * @var string|null
     */
    public $language;

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
     * Saves the user's updated details.
     *
     * @return User
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email
        ];

        $result = $this->client->users->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new User($this->client));
    }
}