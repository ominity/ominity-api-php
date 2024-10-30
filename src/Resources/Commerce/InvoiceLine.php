<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\Modules\Bookings\Booking;
use Ominity\Api\Resources\ResourceFactory;

class InvoiceLine extends BaseResource
{
    /**
     * Always 'invoiceline'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the invoiceline.
     *
     * @var int
     */
    public $id;

    /**
     * The ID of the invoice this line belongs to.
     *
     * @var int
     */
    public $invoiceId;

    /**
     * If a orderable item was related to this invoice line, the orderable
     * item's ID and type will be available here as well.
     * 
     * @var \stdClass|null
     */
    public $orderable;

    /**
     * The number of items in the invoice line.
     *
     * @var int
     */
    public $quantity;

    /**
     * The title of the invoice line.
     *
     * @example USB-C to Lightning Cable - 2 meters
     * @var string
     */
    public $title;

    /**
     * Additional description of the invoice line.
     *
     * @var string|null
     */
    public $description;

    /**
     * The price of a single item in the invoice line.
     *
     * @var \stdClass
     */
    public $unitPrice;

    /**
     * Any discounts applied to the invoice line.
     *
     * @var \stdClass|null
     */
    public $discountAmount;

    /**
     * The total amount of the line, including VAT and discounts.
     *
     * @var \stdClass
     */
    public $totalAmount;

    /**
     * The VAT rate applied to the order line. It is defined as a string
     * and not as a float to ensure the correct number of decimals are
     * passed.
     *
     * @example "21.00"
     * @var string
     */
    public $vatRate;

    /**
     * The amount of value-added tax on the line.
     *
     * @var \stdClass
     */
    public $vatAmount;

    /** 
     * UTC datetime the invoice line was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the invoice line was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Get the orderable item related to this invoice line.
     *
     * @return mixed|null
     */
    public function item()
    {
        if (! isset($this->_embedded->item)) {
            return null;
        }

        // Product
        if ($this->_embedded->item->resource === "product") 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->item,
                new Product($this->client)
            );
        }

        // Subscription
        if ($this->_embedded->item->resource === "subscription") 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->item,
                new Subscription($this->client)
            );
        }

        // Module: Bookings
        if ($this->_embedded->item->resource === "bookings_booking") 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->item,
                new Booking($this->client)
            );
        }

        return $this->_embedded->item;
    }
}