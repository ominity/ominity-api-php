<?php

namespace Ominity\Api\Resources;

abstract class BaseCollection extends \ArrayObject
{
    /**
     * Total number of retrieved objects.
     *
     * @var int
     */
    public $count;

    /**
     * @var \stdClass|null
     */
    public $_links;

    /**
     * @param int $count
     * @param \stdClass|null $_links
     */
    public function __construct($count, $_links)
    {
        $this->count = $count;
        $this->_links = $_links;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName();

    /**
     * Get the first item in the collection.
     * 
     * @return mixed
     */
    public function first() {
        return $this->offsetGet(0);
    }

    /**
     * Get the last item in the collection.
     * 
     * @return mixed
     */
    public function last() {
        return $this->offsetGet($this->count - 1);
    }

    /**
     * Merge another collection of the same type into this collection.
     * 
     * @param BaseCollection $otherCollection
     * @return void
     */
    public function merge(BaseCollection $otherCollection) {
        foreach ($otherCollection as $item) {
            $this->append($item);
        }
        $this->count += $otherCollection->count;
    }
}