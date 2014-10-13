<?php

namespace YVR\Util;

class NodeObserver extends Observer
{
    public function doUpdate(Subject $subject)
    {
        SlugPathMapper::instance()
            ->add($subject->getInternalPath(), $subject->getId());
    }
}
