<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseResource;

class UserRecoveryCode extends BaseResource
{
    /**
     * Always 'user_recovery_code'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the recovery code.
     *
     * @var int
     */
    public $id;

    /**
     * The recovery code.
     *
     * @var string
     */
    public $code;

    /** 
     * UTC datetime the recovery code was used in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $usedAt; 

    /** 
     * UTC datetime the recovery code was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the recovery code was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this recovery code active?
     *
     * @return bool
     */
    public function isActive()
    {
        return is_null($this->usedAt);
    }
}