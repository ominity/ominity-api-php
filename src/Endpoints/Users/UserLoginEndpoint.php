<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Users\User;
use Ominity\Api\Resources\Users\UserLogin;
use Ominity\Api\Resources\Users\UserLoginCollection;

class UserLoginEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "users/{userId}/logins";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new UserLoginCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new UserLogin($this->client);
    }

    /**
     * Log a user login event to keep track of logged in devices and locations.
     *
     * @param User $user
     * @param array $data
     * @param array $filters
     *
     * @return UserLogin
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(User $user, array $data, array $filters = [])
    {
        return $this->createForId($user->id, $data, $filters);
    }

    /**
     * Log a user login event to keep track of logged in devices and locations.
     *
     * @param int $userId
     * @param array $data
     * @param array $filters
     *
     * @return UserLogin
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($userId, array $data, array $filters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        return parent::rest_create($data, $filters);
    }

    /**
     * Get the login history record for a specific User.
     *
     * @param User $user
     * @param int $loginId
     * @return UserLogin
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(User $user, int $loginId, array $parameters = []) {
        if (empty($user)) {
            throw new ApiException("User is empty.");
        }

        if (empty($loginId)) {
            throw new ApiException("Login ID is empty.");
        }

        return $this->getForId($user->id, $loginId, $parameters);
    }

    /**
     * Get the login history record a specific User ID.
     *
     * @param int $userId
     * @param int $loginId
     * @return UserLogin
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $userId, int $loginId, array $parameters = []) {
        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        if (empty($loginId)) {
            throw new ApiException("Login ID is empty.");
        }

        $this->setPathVariables(['userId' => $userId]);
        return parent::rest_read($loginId, $parameters);
    }

    /**
     * Retrieves a collection of user logins for a specific User.
     *
     * @param User $user
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return UserLoginCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageFor(User $user, $page = null, $limit = null, array $parameters = [])
    {
        return $this->pageForId($user->id, $page, $limit, $parameters);
    }

    /**
     * Retrieves a collection of user logins for a specific User ID.
     *
     * @param int $userId
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return UserLoginCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageForId(int $userId, $page = null, $limit = null, array $parameters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        return parent::rest_list($page, $limit, $parameters);
    }

    /**
     * Create an iterator for iterating over user logins for the given user retrieved from Ominity.
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
     * Create an iterator for iterating over user logins for the given user id retrieved from Ominity.
     *
     * @param int $userId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $userId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['userId' => $userId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}