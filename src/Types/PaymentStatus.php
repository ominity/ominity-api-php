<?php

namespace Ominity\Api\Types;

class PaymentStatus
{
    public const OPEN = 'open';
    public const PENDING = 'pending';
    public const AUTHORIZED = 'authorized';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';
    public const EXPIRED = 'expired';
    public const FAILED = 'FAILED';
}