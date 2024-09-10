<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseCollection;

class CalendarCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return "bookings_event_occurrences";
    }

    /**
     * Get a specific event occurrence.
     * Returns null if the event occurrence cannot be found.
     *
     * @param  string $occurrenceId
     * @return EventOccurrence|null
     */
    public function get($occurrenceId)
    {
        foreach ($this as $occurrence) {
            if ($occurrence->id == $occurrenceId) {
                return $occurrence;
            }
        }

        return null;
    }
}