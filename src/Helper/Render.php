<?php

namespace Tree\Helper;

use Tree\TreeBuilder;
use Tree\Util\SlugPathMapper;
use Voltus\File\FileReader;
use Voltus\File\FileWriter;

class Render
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
            $fr = new FileReader($path);
            $contentType = pathinfo($path, PATHINFO_EXTENSION);
            return new Output($fr->getContent(), Output::TYPE_CONTENT, $contentType);
        }

        $tree = (new TreeBuilder($path))->recursive(false)->get();

        $slugPathMapper += SlugPathMapper::instance()->getArray();

        $fw->save(serialize($slugPathMapper));

        $htmlTree = Html::printTree($tree, SlugPathMapper::instance()->getArray());

        return  new Output($htmlTree);
    }
}
