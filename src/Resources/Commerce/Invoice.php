<?php

namespace Ominity\Api\Resources\Commerce;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;
use Ominity\Api\Types\InvoiceStatus;

class Invoice extends BaseResource
{
    /**
     * Always 'invoice'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the invoice.
     *
     * @var int
     */
    public $id;

    /**
     * If a customer was related to this invoice, the customer's ID will
     * be available here as well.
     *
     * @var int|null
     */
    public $customerId;

    /**
     * If a status of this invoice is not DRAFT the invoice number will
     * be available here as well.
     *
     * @var string|null
     */
    public $number;

    /**
     * The status of the invoice.
     *
     * @var string
     */
    public $status = InvoiceStatus::DRAFT;

    /**
     * If a specific email was provided for this invoice the email address will
     * be available here as well.
     *
     * @var string|null
     */
    public $email;

    /**
     * If this invoice was placed as a company the company name will
     * be available here as well.
     *
     * @var string|null
     */
    public $companyName;

    /**
     * If this invoice was placed as a company the company vat number will
     * be available here as well.
     *
     * @var string|null
     */
    public $companyVat;

    /**
     * The billing address for this invoice.
     *
     * @var \stdClass
     */
    public $billingAddress;
    
    /**
     * Subtotal amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $subtotalAmount;

    /**
     * Discount amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $discountAmount;

    /**
     * The amount of value-added tax on this invoice containing the value and currency
     *
     * @var \stdClass
     */
    public $vatAmount;

    /**
     * Total amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $totalAmount;

    /**
     * Amount paid object containing the value and currency
     *
     * @var \stdClass
     */
    public $amountPaid;

    /** 
     * UTC datetime of the invoice date in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $invoicedAt;

    /** 
     * UTC datetime of the invoice due date in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $dueAt;

    /** 
     * UTC datetime the invoice was paid in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $paidAt;

    /**
     * The invoice lines contain the actual things the customer bought.
     *
     * @var array|object[]
     */
    public $lines;

    /**
     * Is this invoice tax exempt?
     *
     * @var bool
     */
    public $isTaxExempt;

    /**
     * Notes for the invoice.
     *
     * @var string
     */
    public $notes;

    /** 
     * UTC datetime the invoice was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the invoice was created in ISO-8601 format.
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
     * Is this payment still open / ongoing?
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === InvoiceStatus::DRAFT;
    }

    /**
     * Is this invoice still unpaid?
     *
     * @return bool
     */
    public function isUnpaid()
    {
        return $this->status === InvoiceStatus::UNPAID;
    }

    /**
     * Is this invoice paid?
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->status === InvoiceStatus::PAID;
    }

    /**
     * Is this invoice credited?
     *
     * @return bool
     */
    public function isCredited()
    {
        return $this->status === InvoiceStatus::CREDITED;
    }

    /**
     * Is this invoice refunded?
     *
     * @return bool
     */
    public function isRefunded()
    {
        return $this->status === InvoiceStatus::REFUNDED;
    }

    /**
     * Is this order partially completed?
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === InvoiceStatus::CANCELLED;
    }

    /**
     * Get the customer related to this invoice.
     *
     * @return Customer|null
     */
    public function customer()
    {
        if (empty($this->customerId)) {
            return null;
        }

        if (isset($this->_embedded, $this->_embedded->customer)) 
        {
            return ResourceFactory::createFromApiResult(
                $this->_embedded->customer,
                new Customer($this->client)
            );
        }

        return $this->client->commerce->customers->get($this->customerId);
    }

    /**
     * Get the line value objects
     *
     * @return InvoiceLineCollection
     */
    public function lines()
    {
        return ResourceFactory::createBaseResourceCollection(
            $this->client,
            InvoiceLine::class,
            $this->lines
        );
    }

    /**
     * Get the invoice PDF
     * 
     * @return string
     */
    public function pdf() {
        return $this->client->commerce->invoices->pdf($this->id);
    }

    /**
     * Retrieve the payments for this invoice.
     * Requires the invoice to be retrieved using the embed payments parameter.
     *
     * @return null|\Ominity\Api\Resources\Commerce\PaymentCollection
     */
    public function payments()
    {
        if (isset($this->_embedded, $this->_embedded->payments)) 
        {
            return ResourceFactory::createCursorResourceCollection(
                $this->client,
                $this->_embedded->payments,
                Payment::class
            );
        }
    }
}