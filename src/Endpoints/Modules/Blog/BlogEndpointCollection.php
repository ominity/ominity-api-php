<?php

namespace Ominity\Api\Endpoints\Modules\Blog;

use Ominity\Api\Endpoints\EndpointCollectionAbstract;

class BlogEndpointCollection extends EndpointCollectionAbstract
{
    /**
     * RESTful Category resource.
     *
     * @var CategoryEndpoint
     */
    public $categories;

    /**
     * RESTful Post resource.
     *
     * @var PostEndpoint
     */
    public $posts;

    /**
     * RESTful Tag resource.
     *
     * @var TagEndpoint
     */
    public $tags;

    public function initializeEndpoints()
    {
        $this->categories = new CategoryEndpoint($this->client);
        $this->posts = new PostEndpoint($this->client);
        $this->tags = new TagEndpoint($this->client);
    }
}