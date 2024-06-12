<?php

namespace Ominity\Api\Endpoints\Settings;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Settings\SocialProvider;
use Ominity\Api\Resources\Settings\SocialProviderUser;
use Ominity\Api\Resources\Settings\SocialProviderUserCollection;

class SocialProviderUserEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "settings/socialproviders/{providerId}/users";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new SocialProviderUserCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new SocialProviderUser($this->client);
    }

    /**
     * Update a specific SocialProvider resource
     *
     * Will throw a ApiException if the userId id is invalid or the resource cannot be found.
     *
     * @param string $userId
     *
     * @param array $data
     * @return SocialProviderUser
     * @throws ApiException
     */
    public function updateFor(SocialProvider $provider, $userId, array $data = [])
    {
        if (empty($provider)) {
            throw new ApiException("Provider is empty.");
        }

        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        return $this->updateForId($provider->id, $userId, $data);
    }

    /**
     * Update a specific SocialProvider resource
     *
     * Will throw a ApiException if the userId id is invalid or the resource cannot be found.
     *
     * @param int $providerId
     * @param string $userId
     *
     * @param array $data
     * @return SocialProviderUser
     * @throws ApiException
     */
    public function updateForId(int $providerId, $userId, array $data = [])
    {
        if (empty($providerId)) {
            throw new ApiException("Provider ID is empty.");
        }

        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        $this->setPathVariables(['providerId' => $providerId]);
        return parent::rest_update($userId, $data);
    }

    /**
     * Get the user record for a specific SocialProvider by a one-time usage auth code.
     *
     * @param SocialProvider $provider
     * @param string $code
     * @return SocialProviderUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForByCode(SocialProvider $provider, string $code, array $parameters = []) {
        if (empty($provider)) {
            throw new ApiException("Provider is empty.");
        }

        if (empty($code)) {
            throw new ApiException("Code is empty.");
        }

        return $this->getForIdByCode($provider->id, $code, $parameters);
    }

    /**
     * Get the user record for a specific SocialProvider ID by a one-time usage auth code.
     *
     * @param int $providerId
     * @param string $code
     * @return SocialProviderUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForIdByCode(int $providerId, string $code, array $parameters = []) {
        if (empty($providerId)) {
            throw new ApiException("Provider ID is empty.");
        }

        if (empty($code)) {
            throw new ApiException("Code is empty.");
        }

        $parameters = array_merge($parameters, [
            'code' => $code
        ]);

        $this->setPathVariables(['providerId' => $providerId]);
        return parent::rest_read('token', $parameters);
    }

    /**
     * Get the user record for a specific SocialProvider.
     *
     * @param SocialProvider $provider
     * @param int $userId
     * @return SocialProviderUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(SocialProvider $provider, int $userId, array $parameters = []) {
        if (empty($provider)) {
            throw new ApiException("Provider is empty.");
        }

        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        return $this->getForId($provider->id, $userId, $parameters);
    }

    /**
     * Get the user record for a specific SocialProvider ID.
     *
     * @param int $providerId
     * @param int $userId
     * @return SocialProviderUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $providerId, int $userId, array $parameters = []) {
        if (empty($providerId)) {
            throw new ApiException("Provider ID is empty.");
        }

        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        $this->setPathVariables(['providerId' => $providerId]);
        return parent::rest_read($userId, $parameters);
    }

    /**
     * Retrieves a collection of users for a specific SocialProvider.
     *
     * @param SocialProvider $provider
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return SocialProviderUserCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageFor(SocialProvider $provider, $page = null, $limit = null, array $parameters = [])
    {
        return $this->pageForId($provider->id, $page, $limit, $parameters);
    }

    /**
     * Retrieves a collection of users for a specific SocialProvider ID.
     *
     * @param int $providerId
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return SocialProviderUserCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageForId(int $providerId, $page = null, $limit = null, array $parameters = [])
    {
        $this->setPathVariables(['providerId' => $providerId]);

        return parent::rest_list($page, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over users for the given provider retrieved from Ominity.
     *
     * @param SocialProvider $provider
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(SocialProvider $provider, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($provider->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over users for the given provider id retrieved from Ominity.
     *
     * @param int $providerId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $providerId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['providerId' => $providerId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}