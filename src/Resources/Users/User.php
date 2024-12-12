<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Commerce\CustomerUser;
use Ominity\Api\Resources\Commerce\CustomerUserCollection;
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
     * Custom field values of the user.
     *
     * @var \stdClass
     */
    public $customFields;

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
            "email" => $this->email,
            "avatar" => $this->avatar,
        ];

        $result = $this->client->users->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new User($this->client));
    }

    /**
     * Get access token for this user
     *
     * @return \stdClass
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function token()
    {
        if (! isset($this->_links->token->href)) {
            throw new ApiException("API key required for this operation");
        }

        return $this->client->performHttpCallToFullUrl(
            OminityApiClient::HTTP_GET,
            $this->_links->token->href
        );
    }

    /**
     * Get all customer accounts for this user
     *
     * @return CustomerUserCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function customers()
    {
        if (isset($this->_embedded, $this->_embedded->customers)) 
        {
            return ResourceFactory::createCursorResourceCollection(
                $this->client, 
                $this->_embedded->customers,
                CustomerUser::class,
            );
        }

        return $this->client->users->customers->allFor($this);
    }

    /**
     * Get all oauth accounts for this user
     *
     * @return SocialProviderUserCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function oauthaccounts()
    {
        return $this->client->users->oauthaccounts->allFor($this);
    }

    /**
     * Get all recovery codes for this user
     *
     * @return UserRecoveryCodeCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function recoverycodes()
    {
        return $this->client->users->recoverycodes->listFor($this);
    }
}