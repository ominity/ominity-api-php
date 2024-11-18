<?php

namespace Ominity\Api\Endpoints\Modules\Knowledgebase;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Modules\Knowledgebase\Article;
use Ominity\Api\Resources\Modules\Knowledgebase\ArticleFeedback;
use Ominity\Api\Resources\Modules\Knowledgebase\ArticleFeedbackCollection;

class ArticleFeedbackEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "modules/knowledgebase/articles/{articleId}/feedbacks";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new ArticleFeedbackCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new ArticleFeedback($this->client);
    }

    /**
     * Create a new feedback for a specific Article.
     *
     * @param Article $article
     * @param array $data
     * @param array $filters
     *
     * @return ArticleFeedback
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(Article $article, array $data, array $filters = [])
    {
        return $this->createForId($article->id, $data, $filters);
    }

    /**
     * Create a new feedback for a specific Article ID.
     *
     * @param int $articleId
     * @param array $data
     * @param array $filters
     *
     * @return ArticleFeedback
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($articleId, array $data, array $filters = [])
    {
        $this->setPathVariables(['articleId' => $articleId]);

        return parent::rest_create($data, $filters);
    }

    /**
     * Get the feedback for a specific Article.
     *
     * @param Article $article
     * @param int $feedbackId
     * @return ArticleFeedback
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Article $article, int $feedbackId, array $parameters = []) {
        if (empty($article)) {
            throw new ApiException("Article is empty.");
        }

        if (empty($feedbackId)) {
            throw new ApiException("Feedback ID is empty.");
        }

        return $this->getForId($article->id, $feedbackId, $parameters);
    }

    /**
     * Get the feedback for a specific Article ID.
     *
     * @param int $articleId
     * @param int $feedbackId
     * @return ArticleFeedback
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $articleId, int $feedbackId, array $parameters = []) {
        if (empty($articleId)) {
            throw new ApiException("Article ID is empty.");
        }

        if (empty($feedbackId)) {
            throw new ApiException("Feedback ID is empty.");
        }

        $this->setPathVariables(['articleId' => $articleId]);
        return parent::rest_read($feedbackId, $parameters);
    }

    /**
     * List the feedbacks for a specific Article.
     *
     * @param Article $article
     * @param array $parameters
     * @return ArticleFeedbackCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Article $article, array $parameters = [])
    {
        return $this->listForId($article->id, $parameters);
    }

    /**
     * List the feedbacks for a specific Article ID.
     *
     * @param int $articleId
     * @param array $parameters
     * @return ArticleFeedbackCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $articleId, array $parameters = [])
    {
        $this->setPathVariables(['articleId' => $articleId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over feedbacks for the given article retrieved from Ominity.
     *
     * @param Article $article
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Article $article, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($article->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over feedbacks for the given article id retrieved from Ominity.
     *
     * @param int $articleId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $articleId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['articleId' => $articleId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}