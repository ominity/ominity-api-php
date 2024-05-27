<?php

namespace Ominity\Api\Types;

class SubscriptionStatus
{
    public const PENDING = 'pending';
    public const ACTIVE = 'active';
    public const PAUSED = 'paused';
    public const SUSPENDED = 'suspended';
    public const TERMINATED = 'terminated';
    public const CANCELLED = 'cancelled';
}