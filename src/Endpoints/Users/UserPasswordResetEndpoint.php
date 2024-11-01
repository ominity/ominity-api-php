<?php

namespace Ominity\Api\Endpoints\Users;

use Ominity\Api\Endpoints\EndpointAbstract;

class UserPasswordResetEndpoint extends EndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "users/password-reset/{action}";

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return null;
    }

    /**
     * Send a password reset for a user.
     *
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function send(array $data, array $filters = [])
    {
        $this->setPathVariables(['action' => 'send']);

        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . $this->buildQueryString($filters),
            $this->parseRequestBody($data)
        );

        return $result->success;
    }

    /**
     * Update a user's password.
     *
     * @param array $data
     * @param array $filters
     *
     * @return bool
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update(array $data, array $filters = [])
    {
        $this->setPathVariables(['action' => 'update']);

        $result = $this->client->performHttpCall(
            self::REST_UPDATE,
            $this->getResourcePath() . $this->buildQueryString($filters),
            $this->parseRequestBody($data)
        );

        return $result->success;
    }
}