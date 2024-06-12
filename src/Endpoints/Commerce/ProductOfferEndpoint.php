<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Product;
use Ominity\Api\Resources\Commerce\ProductOffer;
use Ominity\Api\Resources\Commerce\ProductOfferCollection;

class ProductOfferEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "commerce/products/{productId}/offers";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ProductOfferCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new ProductOffer($this->client);
    }

    /**
     * Get the offer for a specific Product.
     *
     * @param Product $product
     * @param int $offerId
     * @return ProductOffer
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Product $product, int $offerId, array $parameters = []) {
        if (empty($product)) {
            throw new ApiException("Product is empty.");
        }

        if (empty($offerId)) {
            throw new ApiException("Offer ID is empty.");
        }

        return $this->getForId($product->id, $offerId, $parameters);
    }

    /**
     * Get the offer for a specific Product ID.
     *
     * @param int $productId
     * @param int $offerId
     * @return ProductOffer
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $productId, int $offerId, array $parameters = []) {
        if (empty($productId)) {
            throw new ApiException("Product ID is empty.");
        }

        if (empty($offerId)) {
            throw new ApiException("Offer ID is empty.");
        }

        $this->setPathVariables(['productId' => $productId]);
        return parent::rest_read($offerId, $parameters);
    }

    /**
     * List the offers for a specific Product.
     *
     * @param Product $product
     * @param array $parameters
     * @return ProductOfferCollection|\Ominity\Api\Resources\BaseCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Product $product, array $parameters = [])
    {
        return $this->listForId($product->id, $parameters);
    }

    /**
     * Create an iterator for iterating over product offers for the given product retrieved from Ominity.
     *
     * @param Product $product
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Product $product, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($product->id, $parameters, $iterateBackwards);
    }

    /**
     * List the offers for a specific Product ID.
     *
     * @param string $productId
     * @param array $parameters
     * @return ProductOfferCollection|\Ominity\Api\Resources\BaseCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $productId, array $parameters = [])
    {
        $this->setPathVariables(['productId' => $productId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over product offers for the given product id retrieved from Ominity.
     *
     * @param string $productId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $productId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['productId' => $productId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}