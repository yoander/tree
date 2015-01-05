<?php

namespace Tree\Helper;

use Tree\TreeBuilder;
use Tree\Util\SlugPathMapper;
use Voltus\File\FileReader;
use Voltus\File\FileWriter;

class Writer 
{
    public static function ($slug, $content = '')
    {
        $slugPathMapper = [];
        $file = sys_get_temp_dir() . '/tree.txt';

        if (empty($slug)) {
            $path = $basePath;
        } else {
            $fr = new FileReader($file);
            $slugPathMapper = unserialize($fr->getContent());
            $path = isset($slugPathMapper[$slug]) ? $slugPathMapper[$slug] : '';
        }

        $fw = new FileWriter($path);
        
        return $fw->save($content);
    }
}
