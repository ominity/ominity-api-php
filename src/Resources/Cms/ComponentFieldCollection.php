<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseCollection;

class ComponentFieldCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * Get a specific component field.
     * Returns null if the order line cannot be found.
     *
     * @param  int $fieldId
     * @return ComponentField|null
     */
    public function get($fieldId)
    {
        foreach ($this as $field) {
            if ($field->id == $fieldId) {
                return $field;
            }
        }

        return null;
    }
}