<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Cart;
use Ominity\Api\Resources\Commerce\CartItem;
use Ominity\Api\Resources\Commerce\CartItemCollection;

class CartItemEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "commerce/carts/{cartId}/items";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new CartItemCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new CartItem($this->client);
    }

    /**
     * Create a new cart item for a specific Cart.
     *
     * @param Cart $carts
     * @param array $data
     * @param array $filters
     *
     * @return CartItem
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(Cart $cart, array $data, array $filters = [])
    {
        return $this->createForId($cart->id, $data, $filters);
    }

    /**
     * Create a new cart item for a specific Cart ID.
     *
     * @param string $cartId
     * @param array $data
     * @param array $filters
     *
     * @return CartItem
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($cartId, array $data, array $filters = [])
    {
        $this->setPathVariables(['cartId' => $cartId]);

        return parent::rest_create($data, $filters);
    }

    /**
     * Update an cart item for a specific Cart.
     *
     * @param Cart $cart
     * @param string $itemId
     * @param array $data
     *
     * @return CartItem
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function updateFor(Cart $cart, int $itemId, array $data)
    {
        return $this->updateForId($cart->id, $itemId, $data);
    }

    /**
     * Update an cart item for a specific Cart ID.
     *
     * @param string $cartId
     * @param string $itemId
     * @param array $data
     *
     * @return CartItem
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function updateForId($cartId, string $itemId, array $data)
    {
        $this->setPathVariables(['cartId' => $cartId]);

        return parent::rest_update($itemId, $data);
    }

    /**
     * Deletes the given cart item for a specific Cart.
     *
     * Will throw a ApiException if the cart item id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param Cart $cart
     * @param string $itemId
     *
     * @param array $data
     * @return CartItem
     * @throws ApiException
     */
    public function deleteFor(Cart $cart, string $itemId, array $data = [])
    {
        return $this->deleteForId($cart->id, $itemId, $data);
    }

    /**
     * Deletes the given cart item for a specific Cart ID.
     *
     * Will throw a ApiException if the cart item id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $cartId
     * @param string $itemId
     *
     * @param array $data
     * @return CartItem
     * @throws ApiException
     */
    public function deleteForId(string $cartId, string $itemId, array $data = [])
    {
        $this->setPathVariables(['cartId' => $cartId]);

        return $this->rest_delete($itemId, $data);
    }

    /**
     * Get the item for a specific Cart.
     *
     * @param Cart $cart
     * @param string $itemId
     * @return CartItem
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Cart $cart, string $itemId, array $parameters = []) {
        if (empty($cart)) {
            throw new ApiException("Cart is empty.");
        }

        if (empty($itemId)) {
            throw new ApiException("Item ID is empty.");
        }

        return $this->getForId($cart->id, $itemId, $parameters);
    }

    /**
     * Get the item for a specific Cart ID.
     *
     * @param string $cartId
     * @param string $itemId
     * @return CartItem
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(string $cartId, string $itemId, array $parameters = []) {
        if (empty($cartId)) {
            throw new ApiException("Cart ID is empty.");
        }

        if (empty($itemId)) {
            throw new ApiException("Item ID is empty.");
        }

        $this->setPathVariables(['cartId' => $cartId]);
        return parent::rest_read($itemId, $parameters);
    }

    /**
     * List the items for a specific Cart.
     *
     * @param Cart $cart
     * @param array $parameters
     * @return CartItemCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Cart $cart, array $parameters = [])
    {
        return $this->listForId($cart->id, $parameters);
    }

    /**
     * Create an iterator for iterating over cart items for the given cart retrieved from Ominity.
     *
     * @param Cart $cart
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Cart $cart, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($cart->id, $parameters, $iterateBackwards);
    }

    /**
     * List the items for a specific Cart ID.
     *
     * @param string $cartId
     * @param array $parameters
     * @return CartItemCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(string $cartId, array $parameters = [])
    {
        $this->setPathVariables(['cartId' => $cartId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over cart items for the given cart id retrieved from Ominity.
     *
     * @param string $cartId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(string $cartId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['cartId' => $cartId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}