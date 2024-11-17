<?php

namespace Ominity\Api\Endpoints\Modules;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;
use Ominity\Api\Endpoints\Modules\Blog\BlogEndpointCollection;
use Ominity\Api\Endpoints\Modules\Bookings\BookingEndpoint;
use Ominity\Api\Endpoints\Modules\Forms\FormsEndpointCollection;
use Ominity\Api\Endpoints\Modules\Knowledgebase\KnowledgebaseEndpointCollection;

class ModulesEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Blog module endppoints.
     *
     * @var BlogEndpointCollection
     */
    public $blog;

    /**
     * RESTful Bookings module endppoints.
     *
     * @var BookingEndpoint
     */
    public $bookings;

    /**
     * RESTful Forms module endppoints.
     *
     * @var FormsEndpointCollection
     */
    public $forms;

    /**
     * RESTful Forms module endppoints.
     *
     * @var KnowledgebaseEndpointCollection
     */
    public $knowledgebase;

    public function initializeEndpoints()
    {
        $this->blog = new BlogEndpointCollection($this->client);
        $this->bookings = new BookingEndpoint($this->client);
        $this->forms = new FormsEndpointCollection($this->client);
        $this->knowledgebase = new KnowledgebaseEndpointCollection($this->client);
    }
}