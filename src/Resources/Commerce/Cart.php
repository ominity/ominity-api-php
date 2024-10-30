<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Resources\Settings\Country;

class Cart extends BaseResource
{
    /**
     * Always 'cart'
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
     * Visitor ID of the cart.
     *
     * @var int|null
     */
    public $visitorId;

    /**
     * Customer ID of the cart.
     *
     * @var int|null
     */
    public $customerId;

     /**
     * User ID of the cart.
     *
     * @var int|null
     */
    public $userId;

    /**
     * Status of the cart.
     *
     * @var string
     */
    public $status;

    /**
     * Type of the cart.
     *
     * @var string
     */
    public $type;

    /**
     * The subtotal amount of the cart, excluding discounts and shipping fees.
     *
     * @var \stdClass|null
     */
    public $subtotalAmount;

    /**
     * The shipping amount of the cart.
     *
     * @var \stdClass|null
     */
    public $shippingAmount;

    /**
     * Any discounts applied to the order line.
     *
     * @var \stdClass|null
     */
    public $discountAmount;

    /**
     * The tax amount of the cart.
     *
     * @var \stdClass|null
     */
    public $taxAmount;

    /**
     * The total amount of the cart, including VAT and discounts.
     *
     * @var \stdClass
     */
    public $totalAmount;

    /**
     * Country of the address in ISO 3166-1 alpha-2 format.
     *
     * @var string
     */
    public $country;

    /**
     * Is shipping required for the cart.
     *
     * @var bool
     */
    public $isShippingRequired;

    /**
     * Shipping Method ID of the cart.
     *
     * @var int
     */
    public $shippingMethodId;

    /**
     * The cart items.
     *
     * @var array|object[]
     */
    public $items;

    /**
     * The cart coupons.
     *
     * @var array|string[]
     */
    public $coupons;

    /** 
     * UTC datetime the cart was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the cart was created in ISO-8601 format.
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
     * Get country
     * 
     * @return Country|null
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function country() {
        if (! isset($this->country)) {
            return null;
        }

        return $this->client->settings->countries->get($this->country);
    }

    /**
     * Get the cart item value objects
     *
     * @return CartItemCollection
     */
    public function items()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            CartItem::class,
            $this->items
        );
    }

    /**
     * Remove an item from the cart.
     *
     * @param string $itemId
     * @return void
     */
    public function removeItem($itemId)
    {
        $this->items = array_filter($this->items, function($item) use ($itemId) {
            return $item->id !== $itemId;
        });
    }

    /**
     * Add an item to the cart.
     *
     * @param array $data
     * @return void
     */
    public function addItem($data) 
    {
        $item = new \stdClass();
        foreach ($data as $key => $value) {
            $item->$key = $value;
        }
        $this->items[] = $item;
    }

    /**
     * Saves the cart's updated details.
     *
     * @return Cart
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "currency" => $this->currency,
            "country" => $this->country,
            "shippingMethodId" => $this->shippingMethodId,
            "items" => array_map(function($item) {
                return array_filter([
                    "id" => $item->id ?? null,
                    "productId" => $item->productId,
                    "productOfferId" => $item->productOfferId ?? null,
                    "quantity" => $item->quantity ?? 1,
                ], function($value) {
                    return $value !== null;
                });
            }, $this->items),
            "coupons" => $this->coupons ?? [],
        ];

        $result = $this->client->commerce->carts->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Cart($this->client));
    }
}