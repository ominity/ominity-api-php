<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseResource;

class UserLogin extends BaseResource
{
    /**
     * Always 'user_login'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the login record.
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
     * Ip address of the login.
     *
     * @var string
     */
    public $ipAddress;

    /**
     * Location of the login.
     *
     * @var string
     */
    public $location;

    /**
     * Device of the login.
     *
     * @var string
     */
    public $device;

    /**
     * Browser of the login.
     *
     * @var string
     */
    public $browser;

    /**
     * UserAgent of the login.
     *
     * @var string
     */
    public $userAgent;

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
}