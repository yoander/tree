<?php

namespace Tree\Helper;

use Tree\TreeBuilder;
use Tree\Util\SlugPathMapper;
use Voltus\File\FileReader;
use Voltus\File\FileWriter;

class RenderHelper
{
    public static function output($basePath, $slug = '')
    {
        $slugPathMapper = [];
        $file = sys_get_temp_dir() . '/tree.txt';

        $fw = new FileWriter($file);

        SlugPathMapper::instance()->setBasePath($basePath);

        if (empty($slug)) {
            $path = $basePath;
        } else {
            $fr = new FileReader($file);
            $slugPathMapper = unserialize($fr->getContent());
            $path = isset($slugPathMapper[$slug]) ? $slugPathMapper[$slug] : '';
        }

        if (is_file($path)) {
            return $path;
        }

        $tree = (new TreeBuilder($path))->recursive(false)->get();

        $slugPathMapper += SlugPathMapper::instance()->getArray();

        $fw->save(serialize($slugPathMapper));

        return HtmlHelper::printTree($tree, SlugPathMapper::instance()->getArray());
    }
}
