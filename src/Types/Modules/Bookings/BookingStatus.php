<?php

namespace Ominity\Api\Types\Modules\Bookings;

class BookingStatus
{
    public const PENDING = 'pending';

    public const CONFIRMED = 'confirmed';

    public const CANCELLED = 'cancelled';

    public const COMPLETED = 'completed';

    public const NO_SHOW = 'no_show';

    public const RESCHEDULED = 'rescheduled';
}