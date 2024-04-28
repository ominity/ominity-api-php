<?php

namespace Ominity\Api\Endpoints\Modules\Forms;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Modules\Forms\Submission;
use Ominity\Api\Resources\Modules\Forms\SubmissionCollection;

class SubmissionEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "modules/forms/submissions";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Submission($this->client);
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
        return new SubmissionCollection($this->client, $count, $_links);
    }

    /**
     * Creates a form submission.
     *
     * @param array $data An array containing details on the submission.
     * @param array $filters
     *
     * @return Submission
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Update the given Submission.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param string $submissionId
     *
     * @param array $data
     * @return Submission
     * @throws ApiException
     */
    public function update($submissionId, array $data = [])
    {
        if (empty($submissionId)) {
            throw new ApiException("Invalid submission ID: '{$submissionId}'.");
        }

        return parent::rest_update($submissionId, $data);
    }

    /**
     * Retrieve an Submission from the API.
     *
     * Will throw a ApiException if the page id is invalid or the resource cannot be found.
     *
     * @param string $submissionId
     * @param array $parameters
     *
     * @return Submission
     * @throws ApiException
     */
    public function get($submissionId, array $parameters = [])
    {
        return $this->rest_read($submissionId, $parameters);
    }

    /**
     * Deletes the given Submission.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $submissionId
     *
     * @param array $data
     * @return Submission
     * @throws ApiException
     */
    public function delete($submissionId, array $data = [])
    {
        return $this->rest_delete($submissionId, $data);
    }

    /**
     * Retrieves a collection of Submissions from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return SubmissionCollection
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
     * @return SubmissionCollection
     * @throws ApiException
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over pages retrieved from the API.
     *
     * @param string $page The page number to request
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