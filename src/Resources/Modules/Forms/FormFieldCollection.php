<?php

namespace Ominity\Api\Resources\Modules\Forms;

use Ominity\Api\Resources\BaseCollection;

class FormFieldCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'form_fields';
    }

    /**
     * Get a specific form field.
     * Returns null if the form field cannot be found.
     *
     * @param  int $fieldId
     * @return FormField|null
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