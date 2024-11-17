<?php

namespace Ominity\Api\Endpoints\Modules\Knowledgebase;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class KnowledgebaseEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Article resource.
     *
     * @var ArticleEndpoint
     */
    public $articles;

    /**
     * RESTful Category resource.
     *
     * @var CategoryEndpoint
     */
    public $categories;

    /**
     * RESTful Tag resource.
     *
     * @var TagEndpoint
     */
    public $tags;

    public function initializeEndpoints()
    {
        $this->articles = new ArticleEndpoint($this->client);
        $this->categories = new CategoryEndpoint($this->client);
        $this->tags = new TagEndpoint($this->client);
    }
}