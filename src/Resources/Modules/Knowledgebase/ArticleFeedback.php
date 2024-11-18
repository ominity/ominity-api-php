<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\Modules\Knowledgebase\FeedbackType;

class ArticleFeedback extends BaseResource
{
    /**
     * Always 'knowledgebase_article_feedback'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the knowledge base article.
     *
     * @var int
     */
    public $id;

    /**
     * ID of the article this feedback is related to.
     *
     * @var int
     */
    public $articleId;

    /**
     * ID of the user who gave the feedback.
     *
     * @var int|null
     */
    public $userId;

    /**
     * ID of the visitor who gave the feedback.
     *
     * @var int|null
     */
    public $visitorId;

    /**
     * Type of the feedback.
     *
     * @var string
     */
    public $type;

    /**
     * Rating of the feedback.
     *
     * @var int|null
     */
    public $rating;

    /**
     * Comment of the feedback.
     *
     * @var string
     */
    public $comment;

    /**
     * IP address of the feedback.
     *
     * @var string
     */
    public $ipAddress;

    /**
     * User agent of the feedback.
     *
     * @var string
     */
    public $userAgent;

    /** 
     * UTC datetime the feedback was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the feedback was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this feedback a like?
     * 
     * @return bool
     */
    public function isLike() {
        return $this->type === FeedbackType::LIKE;
    }

    /**
     * Is this feedback a dislike?
     * 
     * @return bool
     */
    public function isDislike() {
        return $this->type === FeedbackType::DISLIKE;
    }

    /**
     * Is this feedback a rating?
     * 
     * @return bool
     */
    public function isRating() {
        return $this->type === FeedbackType::RATING;
    }
}