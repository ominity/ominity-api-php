<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\CustomerUser;
use Ominity\Api\Resources\Commerce\CustomerUserCollection;
use Ominity\Api\Resources\Users\User;

class UserCustomerEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "users/{userId}/customers";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new CustomerUserCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new CustomerUser($this->client);
    }

    /**
     * Get the customer account for a specific User.
     *
     * @param User $user
     * @param int $customerId
     * @return CustomerUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(User $user, int $customerId, array $parameters = []) {
        if (empty($user)) {
            throw new ApiException("User is empty.");
        }

        if (empty($customerId)) {
            throw new ApiException("Customer ID is empty.");
        }

        return $this->getForId($user->id, $customerId, $parameters);
    }

    /**
     * Get the customer account for a specific User ID.
     *
     * @param int $userId
     * @param int $customerId
     * @return CustomerUser
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $userId, int $customerId, array $parameters = []) {
        if (empty($userId)) {
            throw new ApiException("User ID is empty.");
        }

        if (empty($customerId)) {
            throw new ApiException("Customer ID is empty.");
        }

        $this->setPathVariables(['userId' => $userId]);
        return parent::rest_read($customerId, $parameters);
    }

    /**
     * Retrieves a collection of customer accounts for a specific User.
     *
     * @param User $user
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return CustomerUserCollection
     * 
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageFor(User $user, $page = null, $limit = null, array $parameters = [])
    {
        return $this->pageForId($user->id, $page, $limit, $parameters);
    }

    /**
     * Retrieves a collection of customer accounts for a specific User ID.
     *
     * @param int $userId
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return CustomerUserCollection
     * 
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageForId(int $userId, $page = null, $limit = null, array $parameters = [])
    {
        $this->setPathVariables(['userId' => $userId]);

        return parent::rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for pageFor
     *
     * @param User $user
     * @param array $parameters
     *
     * @return CustomerUserCollection
     * @throws \Ominity\Api\Exceptions\ApiException
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
     * @return CustomerUserCollection
     * 
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function allForId(int $userId, array $parameters = [])
    {
        return $this->pageForId($userId, null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over customer accounts for the given user retrieved from Ominity.
     *
     * @param User $user
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     * @return LazyCollection
     */
    public function iteratorFor(User $user, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($user->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over customer accounts for the given user id retrieved from Ominity.
     *
     * @param int $userId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     * @return LazyCollection
     */
    public function iteratorForId(int $userId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['userId' => $userId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}