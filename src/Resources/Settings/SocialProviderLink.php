<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseResource;

class SocialProviderLink extends BaseResource
{
    /**
     * Always 'socialprovider_link'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the social provider.
     *
     * @var int
     */
    public $providerId;

    /**
     * The oauth2 redirect link
     *
     * @var string
     */
    public $redirectUrl;

    /** 
     * UTC datetime the redirect link was created in ISO-8601 format.
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