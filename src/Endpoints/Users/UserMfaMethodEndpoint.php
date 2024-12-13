<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Resources\Users\User;
use Ominity\Api\Resources\Users\UserMfaMethod;
use Ominity\Api\Resources\Users\UserMfaMethodCollection;

class UserMfaMethodEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "users/{userId}/mfa-methods";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new UserMfaMethodCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new UserMfaMethod($this->client);
    }

    /**
     * Enable a specific mfa method for a specific User.
     *
     * @param User $user
     * @param string $method
     * @param array $data
     * @param array $filters
     *
     * @return UserMfaMethodCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function enableFor(User $user, string $method, array $data = [], array $filters = [])
    {
        return $this->enableForId($user->id, $method, $data, $filters);
    }

    /**
     * Enable a specific mfa method for a specific User ID.
     *
     * @param int $userId
     * @param array $data
     * @param array $filters
     *
     * @return UserMfaMethodCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function enableForId($userId, string $method, array $data = [], array $filters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . '/' . $method . $this->buildQueryString($filters),
            $this->parseRequestBody($data)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Get the mfa method for a specific User.
     *
     * @param User $user
     * @param string $method
     * @return UserMfaMethod
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(User $user, string $method, array $parameters = []) {
        if (empty($user)) {
            throw new ApiException("User is empty.");
        }

        if (empty($method)) {
            throw new ApiException("Method is empty.");
        }

        return $this->getForId($user->id, $method, $parameters);
    }

    /**
     * Get the mfa method for a specific User ID.
     *
     * @param int $userId
     * @param string $method
     * @return UserMfaMethod
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $userId, string $method, array $parameters = []) {
        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        if (empty($method)) {
            throw new ApiException("Method is empty.");
        }

        $this->setPathVariables(['userId' => $userId]);
        return parent::rest_read($method, $parameters);
    }

    /**
     * List the mfa methods for a specific User.
     *
     * @param User $user
     * @param array $parameters
     * @return UserMfaMethodCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(User $user, array $parameters = [])
    {
        return $this->listForId($user->id, $parameters);
    }

    /**
     * List the mfa methods for a specific User ID.
     *
     * @param int $userId
     * @param array $parameters
     * @return UserMfaMethodCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $userId, array $parameters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Validate MFA code for a specific User.
     *
     * @param User $user
     * @param string $method
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function validateFor(User $user, string $method, array $data, array $filters = [])
    {
        return $this->validateForId($user->id, $method, $data, $filters);
    }

    /**
     * Validate MFA code for a specific User ID.
     *
     * @param int $userId
     * @param string $method
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function validateForId($userId, string $method, array $data, array $filters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . '/' . $method . '/validate' . $this->buildQueryString($filters),
            $this->parseRequestBody($data)
        );

        return $result->success ?? false;
    }

    /**
     * Disable the given mfa method for a specific User.
     *
     * Will throw a ApiException if the method is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param User $user
     * @param string $method
     * @param array $data
     * @return UserMfaMethod
     * @throws ApiException
     */
    public function disableFor(User $user, string $method, array $data = [])
    {
        return $this->disableForId($user->id, $method, $data);
    }

    /**
     * Disables the given mfa method for a specific User ID.
     *
     * Will throw a ApiException if the method is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param int $userId
     * @param string $method
     * @param array $data
     * @return UserMfaMethod
     * @throws ApiException
     */
    public function disableForId(int $userId, string $method, array $data = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        return $this->rest_delete($method, $data);
    }

    /**
     * Send MFA code for a specific User.
     *
     * @param User $user
     * @param string $method
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function sendFor(User $user, string $method, array $data, array $filters = [])
    {
        return $this->validateForId($user->id, $method, $data, $filters);
    }

    /**
     * Send MFA code for a specific User ID.
     *
     * @param int $userId
     * @param string $method
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function sendForId($userId, string $method, array $data, array $filters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . '/' . $method . '/send' . $this->buildQueryString($filters),
            $this->parseRequestBody($data)
        );

        return $result->success ?? false;
    }
}