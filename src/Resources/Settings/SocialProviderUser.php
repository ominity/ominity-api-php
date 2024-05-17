<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class SocialProviderUser extends BaseResource
{
    /**
     * Always 'socialprovider_user'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the social provider user.
     *
     * @var int
     */
    public $id;

    /**
     * Id of the social provider.
     *
     * @var int
     */
    public $providerId;

    /**
     * Id of the user.
     *
     * @var int|null
     */
    public $userId;

    /**
     * External identifier of the user.
     *
     * @var string
     */
    public $identifier;

    /**
     * Name of the user.
     *
     * @var string
     */
    public $name;

    /**
     * Email of the user.
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
     * Saves the social providers userId
     *
     * @return \Mollie\Api\Resources\SocialProviderUser
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "userId" => $this->userId
        ];

        $result = $this->client->settings->socialproviders->users->updateForId($this->providerId, $this->id, $body);

        return ResourceFactory::createFromApiResult($result, new SocialProviderUser($this->client));
    }

    /**
     * Delete a social provider user
     *
     * @return null|\stdClass|SocialProviderUser
     */
    public function delete() {
        if (! isset($this->_links->self->href)) {
            return $this;
        }

        $result = $this->client->performHttpCallToFullUrl(
            OminityApiClient::HTTP_DELETE,
            $this->_links->self->href
        );

        return $result;
    }
}