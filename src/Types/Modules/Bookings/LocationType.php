<?php

namespace Ominity\Api\Types\Modules\Bookings;

class LocationType
{
    
    public const PHYSICAL = 'physical';

    public const VIRTUAL = 'virtual';

    /** Sub-location types */
    
    public const GROUP = 'group';

    public const ROOM = 'room';

    public const SEATING_AREA = 'seating_area';
}