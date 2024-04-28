<?php

namespace Ominity\Api\Endpoints\Modules\Forms;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class FormsEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Form resource.
     *
     * @var FormEndpoint
     */
    public $forms;

    /**
     * RESTful Submission resource.
     *
     * @var SubmissionEndpoint
     */
    public $submissions;

    public function initializeEndpoints()
    {
        $this->forms = new FormEndpoint($this->client);
        $this->submissions = new SubmissionEndpoint($this->client);
    }
}