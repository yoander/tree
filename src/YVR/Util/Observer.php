<?php

namespace YVR\Util;

abstract class Observer implements \SplObserver
{
    private $subject;

    public function update(\SplSubject $subject)
    {
        if ($subject === $this->subject) {
            $this->doUpdate($subject);
        }
    }

    public function observe(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function __destruct()
    {
        $this->subject->detach($this);
    }

    abstract function doUpdate(Subject $subject);
}
