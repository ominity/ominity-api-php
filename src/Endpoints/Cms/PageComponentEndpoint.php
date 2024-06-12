<?php

namespace Ominity\Api\Endpoints\Cms;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Resources\Cms\Page;
use Ominity\Api\Resources\Cms\PageComponent;
use Ominity\Api\Resources\Cms\PageComponentCollection;

class PageComponentEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "cms/pages/{pageId}/components";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new PageComponentCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new PageComponent($this->client);
    }

    /**
     * List the transactions for a specific Page.
     *
     * @param Page $page
     * @param array $parameters
     * @return PageComponentCollection|\Ominity\Api\Resources\BaseCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Page $page, array $parameters = [])
    {
        return $this->listForId($page->id, $parameters);
    }

    /**
     * Create an iterator for iterating over page components for the given page retrieved from Ominity.
     *
     * @param Page $page
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Page $page, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($page->id, $parameters, $iterateBackwards);
    }

    /**
     * List the components for a specific Page ID.
     *
     * @param string $pageId
     * @param array $parameters
     * @return PageComponentCollection|\Ominity\Api\Resources\BaseCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $pageId, array $parameters = [])
    {
        $this->setPathVariables(['pageId' => $pageId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over page components for the given page id retrieved from Ominity.
     *
     * @param string $pageId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $pageId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['pageId' => $pageId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}