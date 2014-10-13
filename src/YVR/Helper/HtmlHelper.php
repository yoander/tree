<?php

namespace YVR\Helper;

const TREE_TPL = <<<'EOD'
    <ul class="tree">%s</ul>
EOD;

const TREE_BRANCH_TPL = <<<'EOD'
        <li>
            <div id="%s" class="branch"><a href="./#">
                <span class="glyphicon glyphicon-folder-close"></span>
                <span class="node-label">%s</span></a>
                <!-- Tree Child nodes -->
            </div>
            <ul style="display: none">%s</ul>
        </li>
EOD;

const TREE_EMPTY_BRANCH_TPL = <<<'EOD'
        <li>
            <div id="%s" class="branch"><a href="./#">
                <span class="glyphicon glyphicon-folder-close"></span>
                <span class="node-label">%s</span></a>
            </div>
        </li>
EOD;

const TREE_LEAF_TPL = <<<'EOD'
        <li>
            <div id="%s" class="leaf"><a href="%s">
                <span class="glyphicon glyphicon-file"></span>
                <span class="node-label">%s</span></a>
            </div>
        </li>
EOD;

class HtmlHelper
{
    private static $slugMappers = [];

    private static function getNodeTemplate(
        $id,
        $text,
        $hasChildren,
        $isDir,
        $path = '')
    {
        if ($hasChildren) {
            return sprintf(TREE_BRANCH_TPL, $id, $text, '%s');
        } elseif ($isDir) {
            return sprintf(TREE_EMPTY_BRANCH_TPL, $id, $text);
        } else {
            return sprintf(TREE_LEAF_TPL, $id, $path, $text);
        }
    }


    private static function traverse($nodes)
    {

        $items = [];
        foreach ($nodes as $node) {
            if (!$node->hasChildren()) {
                 $items[] =  self::getNodeTemplate(
                    $node->getId(),
                    $node->getText(),
                    $node->hasChildren(),
                    $node->isDir(),
                    self::$slugMappers[$node->getId()]
                 );
            } else {
                $items[] = sprintf(
                    self::getNodeTemplate(
                        $node->getId(),
                        $node->getText(),
                        $node->hasChildren(),
                        $node->isDir()
                    ),
                    implode(
                        '',
                        self::traverse($node->getChildren())
                    )
                );
            }
        }
        return $items;
    }

    public static function printTree($nodes, $slugMappers)
    {
         self::$slugMappers = array_flip($slugMappers);
        $items = self::traverse($nodes);



        d(self::$slugMappers);
        if (!empty($items)) {
            return sprintf(TREE_TPL, implode('', $items));
        }

        return;
    }

}

