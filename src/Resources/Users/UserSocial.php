<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseResource;

class UserSocial extends BaseResource
{
    /**
     * Always 'user_social'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the social record.
     *
     * @var int
     */
    public $id;

    /**
     * Id of the user.
     *
     * @var int
     */
    public $userId;

    /**
     * Provider of the social account
     *
     * @var string
     */
    public $provider;

    /**
     * Indentifier of the social account
     *
     * @var string
     */
    public $identifier;

    /**
     * Token of the social account
     *
     * @var string|null
     */
    public $token;

    /**
     * Refresh token of the social account
     *
     * @var string|null
     */
    public $refreshToken;

    /** 
     * UTC datetime the token expires in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $expiresAt;

    /** 
     * UTC datetime the record was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the record was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;
}