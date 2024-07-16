<?php

namespace Ominity\Api\Endpoints;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\OminityApiClient;

abstract class EndpointAbstract
{
    public const REST_CREATE = OminityApiClient::HTTP_POST;
    public const REST_UPDATE = OminityApiClient::HTTP_PATCH;
    public const REST_READ = OminityApiClient::HTTP_GET;
    public const REST_LIST = OminityApiClient::HTTP_GET;
    public const REST_DELETE = OminityApiClient::HTTP_DELETE;

    /**
     * @var OminityApiClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $resourcePath;

    /**
     * @var array
     */
    protected $pathVariables = [];

    /**
     * @param OminityApiClient $api
     */
    public function __construct(OminityApiClient $api)
    {
        $this->client = $api;
    }

    /**
     * @param array $filters
     * @return string
     */
    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return "";
        }

        foreach ($filters as $key => $value) {
            if ($value === true) {
                $filters[$key] = "true";
            }

            if ($value === false) {
                $filters[$key] = "false";
            }
        }

        return "?" . http_build_query($filters, "", "&");
    }

    /**
     * @param array $body
     * @param array $filters
     * @return mixed
     * @throws ApiException
     */
    protected function rest_create(array $body, array $filters)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath() . $this->buildQueryString($filters),
            $this->parseRequestBody($body)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Sends a PATCH request to a single Ominity API object.
     *
     * @param string $id
     * @param array $body
     *
     * @return mixed
     * @throws ApiException
     */
    protected function rest_update($id, array $body = [])
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            self::REST_UPDATE,
            "{$this->getResourcePath()}/{$id}",
            $this->parseRequestBody($body)
        );

        if ($result == null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Retrieves a single object from the REST API.
     *
     * @param string $id Id of the object to retrieve.
     * @param array $filters
     * @return mixed
     * @throws ApiException
     */
    protected function rest_read($id, array $filters)
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$id}" . $this->buildQueryString($filters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Sends a DELETE request to a single Ominity API object.
     *
     * @param string $id
     * @param array $body
     *
     * @return mixed
     * @throws ApiException
     */
    protected function rest_delete($id, array $body = [])
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            self::REST_DELETE,
            "{$this->getResourcePath()}/{$id}",
            $this->parseRequestBody($body)
        );

        if ($result == null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Download a file stream from the API.
     *
     * @param string $id
     * @param array $filters
     * @param string $accept
     *
     * @return string
     * @throws ApiException
     */
    protected function rest_download($id, array $filters = [], $accept = "application/pdf")
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$id}" . $this->buildQueryString($filters),
            null,
            $accept
        );

        return $result;
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return BaseResource
     */
    abstract protected function getResourceObject();

    /**
     * @param string $resourcePath
     */
    public function setResourcePath($resourcePath)
    {
        $this->resourcePath = strtolower($resourcePath);
    }

    /**
     * @param array $pathVariables
     */
    public function setPathVariables(array $pathVariables)
    {
        $this->pathVariables = $pathVariables;
    }

    /**
     * @return string
     * @throws ApiException
     */
    public function getResourcePath()
    {
        $path = $this->resourcePath;

        foreach ($this->pathVariables as $key => $value) {
            if (empty($value)) {
                throw new ApiException("Path variable '$key' is empty.");
            }
            $path = str_replace('{' . $key . '}', urlencode($value), $path);
        }

        if (preg_match('/\{[^\}]+\}/', $path)) {
            throw new ApiException("Not all path variables are replaced in the resource path: $path.");
        }

        return $path;
    }

    /**
     * @param array $body
     * @return null|string
     */
    protected function parseRequestBody(array $body)
    {
        if (empty($body)) {
            return null;
        }

        return @json_encode($body);
    }
}