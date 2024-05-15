<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseCollection;

class AddressCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'addresses';
    }

    /**
     * Get a specific address.
     * Returns null if the address cannot be found.
     *
     * @param  int $addressId
     * @return Address|null
     */
    public function get($addressId)
    {
        foreach ($this as $address) {
            if ($address->id === $addressId) {
                return $address;
            }
        }

        return null;
    }
}