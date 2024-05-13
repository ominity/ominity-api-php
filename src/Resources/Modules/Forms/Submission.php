<?php

namespace Ominity\Api\Resources\Modules\Forms;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Resources\ResourceFactory;

class Submission extends BaseResource
{
    /**
     * Always 'form_submission'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the submission.
     *
     * @var int
     */
    public $id;

    /**
     * Id of the form.
     *
     * @var int
     */
    public $formId;

    /**
     * Id of the submitting user if any.
     *
     * @var int|null
     */
    public $userId;

    /**
     * Submitted data.
     *
     * @var \stdClass
     */
    public $data;

    /** 
     * UTC datetime the form was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the form was created in ISO-8601 format.
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
     * @return \Ominity\Api\Resources\Modules\Forms\Submission
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "userId" => $this->userId,
            "data" => $this->data
        ];

        $result = $this->client->modules->forms->submissions->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Submission($this->client));
    }
}