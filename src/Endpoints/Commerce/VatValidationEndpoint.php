<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\VatValidation;

class VatValidationEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "commerce/vatvalidations";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Ominity\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new VatValidation($this->client);
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
        return null;
    }

    /**
     * Retrieve an VatValidation object from the API.
     *
     * Will throw a ApiException if the vat number is invalid format.
     *
     * @param string $vatNumber
     * @param array $parameters
     *
     * @return VatValidation
     * @throws ApiException
     */
    public function get($vatNumber, array $parameters = [])
    {
        return $this->rest_read($vatNumber, $parameters);
    }
}