<?php

namespace YVR\Util;

class Registry implements \IteratorAggregate, \Serializable
{
    use SingletonTrait;

    /**
     * Array of nodes
     *
     * @var ArrayIterator $index
     *
     */
    private $index;

    private function __construct()
    {
        $this->index = new \ArrayIterator([]);
    }

    /*public static function instance()
    {
        if (is_null(self::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }*/

    public function add($index, $value)
    {
        $this->index->offsetSet($index, $value);

        return $this;
    }

    public function get($index)
    {
        return $this->index->offsetGet($index);
    }

    public function exists($index)
    {
        return $this->index->offsetExists($index);
    }

    public function hasElements()
    {
        return 0 < $this->index->count();
    }

    public static function remove ( $index )
    {
        $this->index->offsetUnset($index);

        return $this;
    }

    public function getArray()
    {
        return $this->index->getArrayCopy();
    }

    public function getIterator()
    {
        return $this->index;
    }

    public function serialize()
    {
        return serialize($this->index);
    }

    public function unserialize($data)
    {
        $this->index = unserialize($data);
    }
}
