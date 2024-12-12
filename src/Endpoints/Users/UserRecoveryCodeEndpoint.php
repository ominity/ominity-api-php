<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Resources\Users\User;
use Ominity\Api\Resources\Users\UserRecoveryCode;
use Ominity\Api\Resources\Users\UserRecoveryCodeCollection;

class UserRecoveryCodeEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "users/{userId}/recovery-codes";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new UserRecoveryCodeCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new UserRecoveryCode($this->client);
    }

    /**
     * Generate recovery codes for a specific User.
     *
     * @param User $user
     * @param bool $confirm
     * @param array $filters
     *
     * @return UserRecoveryCodeCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function generateFor(User $user, bool $confirm, array $filters = [])
    {
        return $this->generateForId($user->id, $confirm, $filters);
    }

    /**
     * Generate recovery codes for a specific User ID.
     *
     * @param int $userId
     * @param bool $confirm
     * @param array $filters
     *
     * @return UserRecoveryCodeCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function generateForId($userId, bool $confirm, array $filters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . $this->buildQueryString($filters),
            $this->parseRequestBody(['confirm' => $confirm])
        );

        return ResourceFactory::createBaseResourceCollection(
            $this->client, 
            UserRecoveryCode::class, 
            $result,
            $result->_links
        );
    }

    /**
     * List the recovery codes for a specific User.
     *
     * @param User $user
     * @param array $parameters
     * @return UserRecoveryCodeCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(User $user, array $parameters = [])
    {
        return $this->listForId($user->id, $parameters);
    }

    /**
     * List the recovery codes for a specific User ID.
     *
     * @param int $userId
     * @param array $parameters
     * @return UserRecoveryCodeCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $userId, array $parameters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Validate recovery code for a specific User.
     *
     * @param User $user
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function validateFor(User $user, array $data, array $filters = [])
    {
        return $this->validateForId($user->id, $data, $filters);
    }

    /**
     * Validate recovery code for a specific User ID.
     *
     * @param int $userId
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function validateForId($userId, array $data, array $filters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . '/validate' . $this->buildQueryString($filters),
            $this->parseRequestBody($data)
        );

        return $result->success;
    }
}