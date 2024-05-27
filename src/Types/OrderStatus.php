<?php

namespace Ominity\Api\Types;

class OrderStatus
{
    public const DRAFT = 'draft';
    public const PENDING_PAYMENT = 'pending_payment';
    public const OPEN = 'open';
    public const ACCEPTED = 'accepted';
    public const CANCEL_REQUEST = 'cancel_request';
    public const CANCELLED = 'cancelled';
    public const PARTIALLY_COMPLETED = 'partially_completed';
    public const COMPLETED = 'completed';
    public const SHIPPED = 'shipped';
    public const CLOSED = 'closed';
    public const RETURN_REQUEST = 'return_request';
    public const RETURN_ACCEPTED = 'return_accepted';
    public const RETURNED = 'returned';
}