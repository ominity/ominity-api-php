<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class CartItem extends BaseResource
{
    /**
     * Always 'cart_item'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the address.
     *
     * @var int
     */
    public $id;

     /**
     * Cart ID of the cart item.
     *
     * @var string
     */
    public $cartId;

    /**
     * Product ID of the cart item.
     *
     * @var int
     */
    public $productId;

     /**
     * Product Offer ID of the cart item.
     *
     * @var int|null
     */
    public $productOfferId;

    /**
     * Quantity of the cart item.
     *
     * @var int
     */
    public $quantity;

    /**
     * The unit amount of the cart item.
     *
     * @var \stdClass|null
     */
    public $unitAmount;

    /**
     * Any discounts applied to the cart item.
     *
     * @var \stdClass|null
     */
    public $discountAmount;

    /**
     * The tax amount of the cart item.
     *
     * @var \stdClass|null
     */
    public $taxAmount;

    /**
     * The total amount of the cart item, including VAT and discounts.
     *
     * @var \stdClass
     */
    public $totalAmount;

    /**
     * Is shipping required for the cart.
     *
     * @var bool
     */
    public $isShippingRequired;

    /** 
     * UTC datetime the cart item was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the cart item was created in ISO-8601 format.
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
     * Get product
     *
     * @return Product
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function product()
    {
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
     * Get product offer
     *
     * @return ProductOffer
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function productOffer()
    {
        return $this->product()->offers()->get($this->productOfferId);
    }

    /**
     * Saves the cart item's updated details.
     *
     * @return CartItem
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "quantity" => $this->quantity
        ];

        $result = $this->client->commerce->carts->items->updateForId($this->cartId, $this->id, $body);

        return ResourceFactory::createFromApiResult($result, new CartItem($this->client));
    }

    /**
     * Deletes the cart item.
     *
     * @return mixed
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function delete()
    {
        return $this->client->commerce->carts->items->deleteForId($this->cartId, $this->id);
    }
}