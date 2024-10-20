<?php

namespace Ominity\Api\Resources\Cms;

use Ominity\Api\Resources\BaseCollection;

class RouteCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'routes';
    }

    /**
     * Get route by name, id, and optionally locale
     *
     * @param  string $name
     * @param  string|int $id
     * @param  string|null $locale
     * @return Route|null
     */
    public function get($name, $id, $locale = null)
    {
        foreach ($this as $route) {
            if ($route->name == $name && $route->parameters->id == $id && ($locale === null || $route->locale == $locale)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Get route by locale
     *
     * @param  string $locale
     * @return Route|null
     */
    public function getByLocale($locale)
    {
        foreach ($this as $route) {
            if ($route->locale == $route) {
                return $route;
            }
        }

        return null;
    }
}