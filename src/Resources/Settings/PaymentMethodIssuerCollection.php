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
     * Get a specific payment methods issuer.
     * Returns null if the paument method issuer cannot be found.
     *
     * @param  int $issuerId
     * @return PaymentMethodIssuer|null
     */
    public function get($issuerId)
    {
        foreach ($this as $line) {
            if ($line->id == $issuerId) {
                return $line;
            }
        }

        return null;
    }
}