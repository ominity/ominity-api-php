<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\PaginatedCollection;

class InvoiceCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "invoices";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Invoice($this->client);
    }
}