<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Review;
use Ominity\Api\Resources\Commerce\ReviewCollection;
use Ominity\Api\Resources\LazyCollection;

class ReviewEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/reviews";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Review($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return \Ominity\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ReviewCollection($this->client, $count, $_links);
    }

    /**
     * Create a new review.
     *
     * @param array $data
     * @param array $filters
     *
     * @return Review
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function create(array $data, array $filters = [])
    {
        return parent::rest_create($data, $filters);
    }

    /**
     * Update a specific Review resource
     *
     * Will throw a ApiException if the review id is invalid or the resource cannot be found.
     *
     * @param int $reviewId
     * @param array $data
     * @return Review
     * @throws ApiException
     */
    public function update($reviewId, array $data = [])
    {
        if (empty($reviewId)) {
            throw new ApiException("Invalid review ID.");
        }

        return parent::rest_update($reviewId, $data);
    }

    /**
     * Retrieve an review from the API.
     *
     * Will throw a ApiException if the review id is invalid or the resource cannot be found.
     *
     * @param int $reviewId
     * @param array $parameters
     *
     * @return Review
     * @throws ApiException
     */
    public function get($reviewId, array $parameters = [])
    {
        return $this->rest_read($reviewId, $parameters);
    }

    /**
     * Retrieves a collection of reviews from the API.
     *
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return ReviewCollection
     * @throws ApiException
     */
    public function page($page = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for page
     *
     * @param array $parameters
     *
     * @return ReviewCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages retrieved from the API.
     *
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iterator(?string $page = null, ?int $limit = null, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->rest_iterator($page, $limit, $parameters, $iterateBackwards);
    }
}