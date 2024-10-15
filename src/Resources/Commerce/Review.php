<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\ReviewStatus;

class Review extends BaseResource
{
    /**
     * Always 'review'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the review.
     *
     * @var int
     */
    public $id;

    /**
     * ID of the product this review is related to.
     *
     * @var int
     */
    public $productId;

    /**
     * ID of the customer this review is related to.
     *
     * @var int
     */
    public $customerId;

    /**
     * The email of the author of the review.
     *
     * @var string
     */
    public $email;

    /**
     * The name of the author of the review.
     *
     * @var string
     */
    public $name;

    /**
     * The title of the review.
     *
     * @var string
     */
    public $title;

    /**
     * The content of the review.
     *
     * @var string
     */
    public $content;

    /**
     * The rating of the review.
     *
     * @var int
     */
    public $rating;

    /**
     * The media of the review.
     *
     * @var array|string[]
     */
    public $media;

    /**
     * The status of the review.
     *
     * @var string
     */
    public $status;

    /**
     * The original language the review was written in as a ISO 639-1 code.
     *
     * @var string
     */
    public $orignalLanguage;

    /**
     * The country the review was written in as a ISO 3166-1 alpha-2 code.
     *
     * @var string
     */
    public $country;

    /**
     * The custom fields of the review.
     *
     * @var \stdClass
     */
    public $customFields;

    /** 
     * UTC datetime the review was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the review was created in ISO-8601 format.
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
     * Is this review a draft?
     *
     * @return bool
     */
    public function isDraft() {
        return $this->status === ReviewStatus::DRAFT;
    }

    /**
     * Is this review pending?
     *
     * @return bool
     */
    public function isPending() {
        return $this->status === ReviewStatus::PENDING;
    }

    /**
     * Is this review rejected?
     *
     * @return bool
     */
    public function isRejected() {
        return $this->status === ReviewStatus::REJECTED;
    }

    /**
     * Is this review published?
     *
     * @return bool
     */
    public function isPublished() {
        return $this->status === ReviewStatus::PUBLISHED;
    }

    /**
     * Get the product this review is related to.
     *
     * @return Product
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function product()
    {
        if(empty($this->productId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->product)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->product,
                new Product($this->client)
            );
        }
        
        return $this->client->commerce->products->get($this->productId);
    }

    /**
     * Get the customer this review is related to.
     *
     * @return Customer
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function customer()
    {
        if(empty($this->customerId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->customer)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->customer,
                new Customer($this->client)
            );
        }
        
        return $this->client->commerce->customers->get($this->customerId);
    }
}