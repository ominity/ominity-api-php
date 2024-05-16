<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Users\User;
use Ominity\Api\Resources\Users\UserSocial;
use Ominity\Api\Resources\Users\UserSocialCollection;

class UserSocialEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "users_socials";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new UserSocialCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new UserSocial($this->client);
    }

    /**
     * Create a social account for a specific User.
     *
     * @param User $user
     * @param array $data
     * @param array $filters
     *
     * @return UserSocial
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(User $user, array $data, array $filters = [])
    {
        return $this->createForId($user->id, $data, $filters);
    }

    /**
     * Create a social account for a specific User ID.
     *
     * @param int $userId
     * @param array $data
     * @param array $filters
     *
     * @return UserSocial
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($userId, array $data, array $filters = [])
    {
        $this->parentId = $userId;

        return parent::rest_create($data, $filters);
    }

    /**
     * Get the social account for a specific User.
     *
     * @param User $user
     * @param int $socialId
     * @return UserSocial
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(User $user, int $socialId, array $parameters = []) {
        if (empty($user)) {
            throw new ApiException("User is empty.");
        }

        if (empty($socialId)) {
            throw new ApiException("Social ID is empty.");
        }

        return $this->getForId($user->id, $socialId, $parameters);
    }

    /**
     * Get the social account for a specific User ID.
     *
     * @param int $userId
     * @param int $socialId
     * @return UserSocial
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $userId, int $socialId, array $parameters = []) {
        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        if (empty($socialId)) {
            throw new ApiException("Social ID is empty.");
        }

        $this->parentId = $userId;
        return parent::rest_read($socialId, $parameters);
    }

    /**
     * Retrieves a collection of social accounts for a specific User.
     *
     * @param User $user
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return UserSocialCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageFor(User $user, $page = null, $limit = null, array $parameters = [])
    {
        return $this->pageForId($user->id, $page, $limit, $parameters);
    }

    /**
     * Retrieves a collection of social accounts for a specific User ID.
     *
     * @param int $userId
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return UserSocialCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageForId(int $userId, $page = null, $limit = null, array $parameters = [])
    {
        $this->parentId = $userId;

        return parent::rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for pageFor
     *
     * @param User $user
     * @param array $parameters
     *
     * @return UserSocialCollection
     * @throws ApiException
     */
    public function allFor(User $user, array $parameters = [])
    {
        return $this->pageFor($user, null, null, $parameters);
    }

    /**
     * This is a wrapper method for pageForId
     *
     * @param int $userId
     * @param array $parameters
     *
     * @return UserSocialCollection
     * @throws ApiException
     */
    public function allForId(int $userId, array $parameters = [])
    {
        return $this->pageForId($userId, null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over social accounts for the given user retrieved from Ominity.
     *
     * @param User $user
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(User $user, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($user->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over social accounts for the given user id retrieved from Ominity.
     *
     * @param int $userId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $userId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->parentId = $userId;

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}