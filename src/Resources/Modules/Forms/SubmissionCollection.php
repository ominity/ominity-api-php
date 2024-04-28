<?php

namespace Ominity\Api\Resources\Modules\Forms;

use Ominity\Api\Resources\PaginatedCollection;

class SubmissionCollection extends PaginatedCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "form_submissions";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Submission($this->client);
    }
}