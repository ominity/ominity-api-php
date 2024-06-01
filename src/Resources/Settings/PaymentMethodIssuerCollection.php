<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseCollection;

class PaymentMethodIssuerCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * Get a specific order line.
     * Returns null if the order line cannot be found.
     *
     * @param  string $lineId
     * @return PaymentMethodIssuer|null
     */
    public function get($lineId)
    {
        foreach ($this as $line) {
            if ($line->id === $lineId) {
                return $line;
            }
        }

        return null;
    }
}