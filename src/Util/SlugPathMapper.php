<?php

namespace Tree\Util;

use Voltus\Pattern\Registry;
use Voltus\Slugify\Slugify;

class SlugPathMapper extends Registry
{
    private $basePath = null;

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function map($path)
    {
        $slug = str_replace($this->basePath, '', $path);
        $slug = (new Slugify())->slugify($slug);
        parent::add($slug, $path);
    }
}
