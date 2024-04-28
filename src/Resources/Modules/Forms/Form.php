<?php

namespace Ominity\Api\Resources\Modules\Forms;

use Ominity\Api\Resources\BaseResource;

class Form extends BaseResource
{
    /**
     * Always 'form'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the form.
     *
     * @var int
     */
    public $id;

    /**
     * Internal name of the form.
     *
     * @var string
     */
    public $name;

    /**
     * Title of the form.
     *
     * @var string
     */
    public $title;

    /**
     * Description of the form.
     *
     * @var string
     */
    public $description;

    /** 
     * UTC datetime the form was published in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $publishedAt;

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
     * Is this page published?
     *
     * @return bool
     */
    public function isPublished()
    {
        if (is_null($this->publishedAt)) {
            return false;
        }

        $publishedTimestamp = strtotime($this->publishedAt);
        $currentTimestamp = time();

        return $publishedTimestamp <= $currentTimestamp;
    }
}