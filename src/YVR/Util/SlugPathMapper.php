<?php

namespace YVR\Util;

class SlugPathMapper extends Registry
{
    public function add($rawSlug, $path)
    {
        parent::add((new Slugify())->slugify($rawSlug), $path);
    }
}
