<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\PageComponentStatus;

class PageComponent extends BaseResource
{
    /**
     * Always 'page_component'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the page component.
     *
     * @var int
     */
    public $id;

    /**
     * Internal label of the page component.
     *
     * @var string
     */
    public $label;

    /**
     * Status of the page component.
     *
     * @var string
     */
    public $status;

    /**
     * The ID of the page for this page component.
     *
     * @var int
     */
    public $pageId;

    /**
     * The ID of the component for this page component.
     *
     * @var int
     */
    public $componentId;

    /**
     * The page component fields contain the configuration data of the component.
     *
     * @var array|object[]
     */
    public $fields;

    /** 
     * UTC datetime the page component was published in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $publishedAt;

    /** 
     * UTC datetime the page component was last updated in ISO-8601 format.
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
     * Is this page component a draft?
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === PageComponentStatus::DRAFT;
    }

    /**
     * Is this page component scheduled?
     *
     * @return bool
     */
    public function isScheduled()
    {
        return $this->status === PageComponentStatus::SCHEDULED;
    }

    /**
     * Is this page component published?
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === PageComponentStatus::PUBLISHED;
    }

    /**
     * @return Page
     * @throws ApiException
     */
    public function page() 
    {
        return $this->client->cms->pages->get($this->pageId);
    }

    /**
     * @return Component
     * @throws ApiException
     */
    public function component() 
    {
        return $this->client->cms->components->get($this->componentId);
    }

    /**
     * Get the field value objects
     *
     * @return PageComponentFieldCollection
     */
    public function fields()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            PageComponentField::class,
            $this->fields
        );
    }
}