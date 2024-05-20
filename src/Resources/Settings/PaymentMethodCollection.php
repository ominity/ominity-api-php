<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\PaginatedCollection;
use Ominity\Api\Resources\Settings\SocialProvider;

class PaymentMethodCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "paymentmethods";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new PaymentMethod($this->client);
    }
}