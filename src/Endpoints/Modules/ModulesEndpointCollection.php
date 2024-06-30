<?php

namespace Ominity\Api\Endpoints\Modules;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;
use Ominity\Api\Endpoints\Modules\Blog\BlogEndpointCollection;
use Ominity\Api\Endpoints\Modules\Forms\FormsEndpointCollection;

class ModulesEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Blog module endppoints.
     *
     * @var BlogEndpointCollection
     */
    public $blog;

    /**
     * RESTful Forms module endppoints.
     *
     * @var FormsEndpointCollection
     */
    public $forms;

    public function initializeEndpoints()
    {
        $this->blog = new BlogEndpointCollection($this->client);
        $this->forms = new FormsEndpointCollection($this->client);
    }
}