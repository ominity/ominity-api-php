<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\BaseCollection;
use Ominity\Api\Types\ProductOfferType;

class ProductOfferCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'product_offers';
    }

    /**
     * Get a specific product offer.
     * Returns null if the product offer cannot be found.
     *
     * @param  int $productOfferId
     * @return ProductOffer|null
     */
    public function get($productOfferId)
    {
        foreach ($this as $productOffer) {
            if ($productOffer->id === $productOfferId) {
                return $productOffer;
            }
        }

        return null;
    }

    /**
     * Get a specific product offer that is applicable to specific parameters.
     * Returns null if the product offer cannot be found.
     *
     * @param  string|ProductOfferType $type
     * @param  int $quantity Minimum required quantity.
     * @param  int|null $intervalId Optional subscription interval identifier, requried if type is subscirption.
     * @return ProductOffer|null
     * @throws ApiException
     */
    public function getBestMatch($type, $quantity = 1, $intervalId = null) {
        if($type === ProductOfferType::SUBSCRIPTION && $intervalId === null) {
            throw new ApiException("intervalId is required for product offer type subscription.");
        }

        $bestMatchOffer = null;
        foreach($this as $productOffer) {
            if ($productOffer->type === $type && $productOffer->quantity <= $quantity) {
                if($intervalId === null || $productOffer->intervalId === $intervalId) {
                    if ($bestMatchOffer === null || $productOffer->quantity > $bestMatchOffer->quantity) {
                        $bestMatchOffer = $productOffer;
                    }
                }
            }
        }

        return $bestMatchOffer;
    }
}