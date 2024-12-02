<?php

namespace Ominity\Api\Resources\Base;

use Ominity\Api\Resources\Base\Video;
use Ominity\Api\Resources\BaseCollection;

class VideoCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * Get a specific video.
     * Returns null if the video cannot be found.
     *
     * @param  int $videoId
     * @return Video|null
     */
    public function get($videoId)
    {
        foreach ($this as $video) {
            if ($video->id == $videoId) {
                return $video;
            }
        }

        return null;
    }
}