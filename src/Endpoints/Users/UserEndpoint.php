<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Users\User;
use Ominity\Api\Resources\Users\UserCollection;

class UserEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "users";

    /**
     * RESTful CustomerUser resource.
     * 
     * @var UserCustomerEndpoint
     */
    public UserCustomerEndpoint $customers;

    /**
     * RESTful UserLogin resource.
     * 
     * @var UserLoginEndpoint
     */
    public UserLoginEndpoint $logins;

    /**
     * RESTful SocialProviderUser resource.
     * 
     * @var UserOauthAccountEndpoint
     */
    public UserOauthAccountEndpoint $oauthaccounts;

    /**
     * Send and update password reset requests.
     * 
     * @var UserPasswordResetEndpoint
     */
    public UserPasswordResetEndpoint $passwordreset;

    /**
     * Generate and validate recovery codes.
     * 
     * @var UserRecoveryCodeEndpoint
     */
    public UserRecoveryCodeEndpoint $recoverycodes;

    public function __construct(OminityApiClient $client)
    {
        parent::__construct($client);
        
        $this->customers = new UserCustomerEndpoint($client);
        $this->logins = new UserLoginEndpoint($client);
        $this->oauthaccounts = new UserOauthAccountEndpoint($client);
        $this->passwordreset = new UserPasswordResetEndpoint($client);
        $this->recoverycodes = new UserRecoveryCodeEndpoint($client);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new User($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Ominity\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new UserCollection($this->client, $count, $_links);
    }

    /**
     * Creates a user in Ominity.
     *
     * @param array $data An array containing details on the user.
     * @param array $filters
     *
     * @return User
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Update a specific User resource
     *
     * Will throw a ApiException if the user id is invalid or the resource cannot be found.
     *
     * @param int $userId
     * @param array $data
     * @return User
     * @throws ApiException
     */
    public function update($userId, array $data = [])
    {
        if (empty($userId)) {
            throw new ApiException("Invalid user ID.");
        }

        return parent::rest_update($userId, $data);
    }

    /**
     * Retrieve an User from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param string $userId
     * @param array $parameters
     *
     * @return User
     * @throws ApiException
     */
    public function get($userId, array $parameters = [])
    {
        return $this->rest_read($userId, $parameters);
    }

    /**
     * Retrieves a collection of Users from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return UserCollection
     * @throws ApiException
     */
    public function page($page = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for page
     *
     * @param array $parameters
     *
     * @return UserCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages retrieved from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $page = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($page, $limit, $parameters, $iterateBackwards);
    }
}