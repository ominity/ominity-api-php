<?php

namespace Ominity\Api\Endpoints\Cms;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class CmsEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Component resource.
     *
     * @var ComponentEndpoint
     */
    public $components;

    /**
     * RESTful Layout resource.
     *
     * @var LayoutEndpoint
     */
    public $layouts;

    /**
     * RESTful Page resource.
     *
     * @var PageEndpoint
     */
    public $pages;

    /**
     * RESTful Page comonent resource.
     *
     * @var PageComponentEndpoint
     */
    public $pageComponents;

    /**
     * RESTful Route resource.
     *
     * @var PageEndpoint
     */
    public $routes;

    public function initializeEndpoints()
    {
        $this->components = new ComponentEndpoint($this->client);
        $this->layouts = new LayoutEndpoint($this->client);
        $this->pages = new PageEndpoint($this->client);
        $this->pageComponents = new PageComponentEndpoint($this->client);
        $this->routes = new RouteEndpoint($this->client);
    }
}