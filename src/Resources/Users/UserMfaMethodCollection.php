<?php

namespace Ominity\Api\Resources\Users;

use Ominity\Api\Resources\BaseCollection;

class UserMfaMethodCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'user_mfa_methods';
    }

    /**
     * Get a specific mfa method.
     * Returns null if the mfa method cannot be found.
     *
     * @param  string $method
     * @return UserMfaMethod|null
     */
    public function get($method)
    {
        foreach ($this as $mfa) {
            if ($mfa->method == $method) {
                return $mfa;
            }
        }

        return null;
    }
}