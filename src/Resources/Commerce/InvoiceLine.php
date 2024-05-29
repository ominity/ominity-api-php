<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;

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
     * If a product was related to this invoice line the product ID will
     * be available here as well.
     *
     * @var int|null
     */
    public $productId;

    /**
     * The number of items in the invoice line.
     *
     * @var int
     */
    public $quantity;

    /**
     * A short description of the invoice line.
     *
     * @example USB-C to Lightning Cable - 2 meters
     * @var string
     */
    public $name;

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
     * Get the product related to this invoice line if any.
     * 
     * @return Product
     */
    public function getProduct() {
        if (empty($this->productId)) {
            return null;
        }

        $this->client->commerce->products->get($this->productId);
    }
}