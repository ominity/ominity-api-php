<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseResource;

class UserMfaMethod extends BaseResource
{
    /**
     * Always 'user_mfa_method'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the user.
     *
     * @var int
     */
    public $userId;

    /**
     * The MFA method.
     *
     * @var string
     */
    public $method;

    /**
     * Is this MFA method enabled?
     *
     * @var bool
     */
    public $isEnabled;

    /** 
     * UTC datetime the mfa method was verified in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $verifiedAt;

    /** 
     * UTC datetime the mfa method was last used in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $lastUsedAt; 

    /** 
     * UTC datetime the mfa method was last sent in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $lastSentAt; 

    /**
     * The details of the MFA method.
     *
     * @var \stdClass
     */
    public $details;

    /**
     * @var \stdClass
     */
    public $_links;
}