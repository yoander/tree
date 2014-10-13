<?php

namespace YVR\Util;

abstract class Subject implements \SplSubject
{
    /**
     * @property SplObjectStorage $storage
     */
    private $storage;

    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer)
    {
        $this->storage->attach($observer);
    }

    public function detach(\SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    public function detachAll()
    {
        foreach ($this->storage as $observer) {
            $this->storage->detach($observer);
        }
    }

    function notify()
    {
        /** @var \SplObserver $obj **/
        foreach ($this->storage as $obj) {
            $obj->update($this);
        }
    }
}
