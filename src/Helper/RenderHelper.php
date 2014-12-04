<?php

namespace Tree\Helper;

use Tree\TreeBuilder;
use Tree\Util\SlugPathMapper;
use Voltus\Persisten\File\FileStorage;

class RenderHelper
{
    public static function output($basePath, $slug = '')
    {
        $slugPathMapper = [];
        $file = sys_get_temp_dir() . '/tree.txt';
        $fs = new FileStorage($file);

        SlugPathMapper::instance()->setBasePath($basePath);

        if (empty($slug)) {
            $path = $basePath;
        } else {
            $slugPathMapper = $fs->get();
            $path = isset($slugPathMapper[$slug]) ? $slugPathMapper[$slug] : '';
        }

        if (is_file($path)) {
            return $path;
        }

        $tree = (new TreeBuilder($path))->recursive(false)->get();

        $slugPathMapper += SlugPathMapper::instance()->getArray();

        $fs->setData($slugPathMapper)->save();

        return HtmlHelper::printTree($tree, SlugPathMapper::instance()->getArray());
    }
}
