<?php

namespace Ominity\Api\Resources\Base;

use Ominity\Api\Resources\BaseResource;
use Ominity\Api\Types\VideoType;

class Video extends BaseResource
{
    /**
     * Always 'video'
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the video.
     *
     * @var int
     */
    public $id;

    /**
     * Type of the video.
     *
     * @var string
     */
    public $type;

    /**
     * URL of the video.
     *
     * @var string
     */
    public $url;

    /**
     * Thumbnail of the video.
     *
     * @var string
     */
    public $thumbnail;

    /**
     * Order of the video.
     *
     * @var int
     */
    public $order;

    /** 
     * UTC datetime the video was last updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /** 
     * UTC datetime the video was created in ISO-8601 format.
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
     * Is this video uploaded?
     *
     * @return bool
     */
    public function isUpload() {
        return $this->type === VideoType::UPLOAD;
    }

    /**
     * Is this video YouTube?
     *
     * @return bool
     */
    public function isYouTube() {
        return $this->type === VideoType::YOUTUBE;
    }

    /**
     * Is this video Vimeo?
     *
     * @return bool
     */
    public function isVimeo() {
        return $this->type === VideoType::VIMEO;
    }

    /**
     * Is this video TikTok?
     *
     * @return bool
     */
    public function isTikTok() {
        return $this->type === VideoType::TIKTOK;
    }

    /**
     * Is this video url?
     *
     * @return bool
     */
    public function isUrl() {
        return $this->type === VideoType::URL;
    }
}