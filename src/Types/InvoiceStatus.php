<?php

namespace Ominity\Api\Types;

class InvoiceStatus
{
    public const DRAFT = 'draft';
    public const UNPAID = 'unpaid';
    public const PAID = 'paid';
    public const CREDITED = 'credited';
    public const REFUNDED = 'refunded';
    public const CANCELLED = 'cancelled';
}