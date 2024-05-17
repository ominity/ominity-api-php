<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseResource;

class SocialProviderUser extends BaseResource
{
    /**
     * Always 'socialprovider_user'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the social provider user.
     *
     * @var int
     */
    public $id;

    /**
     * Id of the social provider.
     *
     * @var int
     */
    public $providerId;

    /**
     * Name of the user.
     *
     * @var string
     */
    public $name;

    /**
     * Email of the user.
     *
     * @var string
     */
    public $email;

    /**
     * Avatar of the user.
     *
     * @var string
     */
    public $avatar;

    /** 
     * UTC datetime the page was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

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