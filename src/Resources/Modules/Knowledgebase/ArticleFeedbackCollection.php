<?php

namespace Ominity\Api\Resources\Modules\Knowledgebase;

use Ominity\Api\Resources\BaseCollection;

class ArticleFeedbackCollection extends BaseCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return 'knowledgebase_article_feedbacks';
    }

    /**
     * Get the feedback by ID.
     *
     * @param  int $id
     * @return ArticleFeedback|null
     */
    public function get($id)
    {
        foreach ($this as $feedback) {
            if ($feedback->id == $id) {
                return $feedback;
            }
        }

        return null;
    }
}