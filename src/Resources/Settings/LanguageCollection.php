<?php

namespace Ominity\Api\Resources\Settings;

use Ominity\Api\Resources\BaseCollection;
use Ominity\Api\Resources\Settings\Language;

class LanguageCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "languages";
    }

    /**
     * Get a specific language by it's ISO 639-1 code.
     * Returns null if the language cannot be found.
     *
     * @param  string $languageCode
     * @return Language|null
     */
    public function get($languageCode)
    {
        foreach ($this as $language) {
            if ($language->code === $languageCode) {
                return $language;
            }
        }

        return null;
    }

    /**
     * Get default language if in collection.
     * Returns null if the default language is not included in the collection.
     *
     * @return Language|null
     */
    public function getDefault()
    {
        foreach ($this as $language) {
            if ($language->isDefault) {
                return $language;
            }
        }

        return null;
    }
}