<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseCollection;

class CurrencyCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'currencies';
    }

    /**
     * Get a specific currency.
     * Returns null if the currency cannot be found.
     *
     * @param  string $code
     * @return Currency|null
     */
    public function get($code)
    {
        foreach ($this as $currency) {
            if ($currency->code == strtoupper($code)) {
                return $code;
            }
        }

        return null;
    }
}