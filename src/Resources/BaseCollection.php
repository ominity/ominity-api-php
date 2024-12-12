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

        return $this;
    }

    /**
     * Apply a callback to each item in the collection.
     * 
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback) {
        $result = new static($this->count, $this->_links);
        foreach ($this as $key => $item) {
            $result->offsetSet($key, $callback($item));
        }
        return $result;
    }

    /**
     * Apply a callback to each item in the collection and return a new collection with keys.
     * 
     * @param callable $callback
     * @return static
     */
    public function mapWithKey(callable $callback) {
        $result = new static($this->count, $this->_links);
        foreach ($this as $key => $item) {
            $result->offsetSet($key, $callback($key, $item));
        }
        return $result;
    }

    /**
     * Filter the collection using a callback.
     * 
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback) {
        $result = new static(0, $this->_links);
        foreach ($this as $item) {
            if ($callback($item)) {
                $result->append($item);
                $result->count++;
            }
        }
        return $result;
    }

    /**
     * Find an item in the collection by its identifier.
     * 
     * @param mixed $identifier
     * @return mixed|null
     */
    public function find($identifier) {
        foreach ($this as $item) {
            if ($item->id == $identifier) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Get the collection as an array.
     * 
     * @return array
     */
    public function toArray() {
        return $this->getArrayCopy();
    }
}