<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseCollection;

class CartItemCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * Get a specific cart item.
     * Returns null if the cart item cannot be found.
     *
     * @param  int $item
     * @return CartItem|null
     */
    public function get($itemId)
    {
        foreach ($this as $item) {
            if ($item->id == $itemId) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Get a specific cart item by product.
     * Returns null if the cart item cannot be found.
     *
     * @param  int $productId
     * @param  int $productOfferId
     * @return CartItem|null
     */
    public function getByProduct($productId, $productOfferId = null)
    {
        foreach ($this as $item) {
            if ($item->productId == $productId && $item->productOfferId == $productOfferId) {
                return $item;
            }
        }

        return null;
    }
}