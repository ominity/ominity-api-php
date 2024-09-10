<?php

namespace Ominity\Api\Resources\Modules\Bookings;

use Ominity\Api\Resources\BaseCollection;

class ParticipantCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return "bookings_participants";
    }

    /**
     * Get a specific participant.
     * Returns null if the participant cannot be found.
     *
     * @param  string $participantId
     * @return Participant|null
     */
    public function get($participantId)
    {
        foreach ($this as $participant) {
            if ($participant->id == $participantId) {
                return $participant;
            }
        }

        return null;
    }
}