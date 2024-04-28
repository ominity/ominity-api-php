<?php

namespace Ominity\Api\Endpoints\Modules;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;
use Ominity\Api\Endpoints\Modules\Forms\FormsEndpointCollection;

class ModulesEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Forms module endppoints.
     *
     * @var FormsEndpointCollection
     */
    public $forms;

    public function initializeEndpoints()
    {
        $this->forms = new FormsEndpointCollection($this->client);
    }
}