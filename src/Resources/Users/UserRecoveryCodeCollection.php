<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseCollection;

class UserRecoveryCodeCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'user_recovery_codes';
    }

    /**
     * Get a specific recovery code.
     * Returns null if the recovery code cannot be found.
     *
     * @param  int $recoveryCodeId
     * @return FormField|null
     */
    public function get($recoveryCodeId)
    {
        return $this->find($recoveryCodeId);
    }
}