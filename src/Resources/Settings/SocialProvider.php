<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\OminityApiClient;
use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class SocialProvider extends BaseResource
{
    /**
     * Always 'socialprovider'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the social provider.
     *
     * @var int
     */
    public $id;

    /**
     * The provider identifier.
     *
     * @var string
     */
    public $provider;

    /**
     * Name of the provider.
     *
     * @var string
     */
    public $name;

    /**
     * Icon of the provider.
     *
     * @var string
     */
    public $icon;

    /**
     * Is this provider enabled?
     *
     * @var bool
     */
    public $isEnabled;

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

    /**
     * Get a oauth2 redirect link for this provider
     *
     * @param  string $redirectUrl
     * @return SocialProviderLink
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function link($redirectUrl)
    {
        if (! isset($this->_links->link->href)) {
            throw new ApiException("Link not available for this provider");
        }

        $result = $this->client->performHttpCallToFullUrl(
            OminityApiClient::HTTP_GET,
            $this->_links->link->href . '?redirectUrl=' . $redirectUrl
        );

        return ResourceFactory::createFromApiResult($result, new SocialProviderLink($this->client));
    }
}