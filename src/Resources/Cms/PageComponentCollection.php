<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseCollection;

class PageComponentCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'page_components';
    }

    /**
     * Get a specific page component.
     * Returns null if the page component cannot be found.
     *
     * @param  int $pageComponentId
     * @return PageComponent|null
     */
    public function get($pageComponentId)
    {
        foreach ($this as $pageComponent) {
            if ($pageComponent->id === $pageComponentId) {
                return $pageComponent;
            }
        }

        return null;
    }
}