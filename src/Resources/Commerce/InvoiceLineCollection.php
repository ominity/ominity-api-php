<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseCollection;

class InvoiceLineCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * Get a specific invoice line.
     * Returns null if the invoice line cannot be found.
     *
     * @param  int $lineId
     * @return InvoiceLine|null
     */
    public function get($lineId)
    {
        foreach ($this as $line) {
            if ($line->id == $lineId) {
                return $line;
            }
        }

        return null;
    }
}