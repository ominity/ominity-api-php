<?php

namespace Ominity\Api\Endpoints\Settings;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Resources\Settings\Country;

class CountryEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "countries";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new Country($this->client);
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
        return new CountryEndpoint($this->client, $count, $_links);
    }

    /**
     * Retrieve an Country from the API.
     *
     * Will throw a ApiException if the country id is invalid or the resource cannot be found.
     *
     * @param string $countryId
     * @param array $parameters
     *
     * @return Country
     * @throws ApiException
     */
    public function get($countryId, array $parameters = [])
    {
        return $this->rest_read($countryId, $parameters);
    }

    /**
     * Retrieve an Country from the API by it's ISO 3166-1 alpha-2 code.
     *
     * Will throw a ApiException if the country code is invalid or the resource cannot be found.
     *
     * @param string $countryCode
     * @param array $parameters
     *
     * @return Country|null
     * @throws ApiException
     */
    public function getByCode($countryCode, array $parameters = [])
    {
        $parameters = array_merge([
            'filter' => [
                'code' => $countryCode
            ]
        ], $parameters);

        $result = $this->page(1, 1, $parameters);

        if($result->count > 0) {
            return $result[0];
        }

        return null;
    }

    /**
     * Retrieves a collection of Countries from the API.
     *
     * @param string $page The page number to request
     * @param int $limit
     * @param array $parameters
     *
     * @return CountryCollection
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
     * @return CountryCollection
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
