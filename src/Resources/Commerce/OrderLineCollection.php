<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseCollection;

class OrderLineCollection extends BaseCollection
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
     * @param  int $lineId
     * @return OrderLine|null
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