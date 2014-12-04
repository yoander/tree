<?php

namespace Tree\Util;

use Voltus\Pattern\Observer;
use Voltus\Pattern\Subject;

class NodeObserver extends Observer
{
    public function doUpdate(Subject $subject)
    {
        SlugPathMapper::instance()
            ->map($subject->getRealPath());
    }
}
