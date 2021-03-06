<?php

namespace Tree\Helper;

const TREE_TPL = <<<'EOD'
    <ul class="tree">%s</ul>
EOD;

const TREE_BRANCH_TPL = <<<'EOD'
        <li class="branch">
            <div id="%s"><a href="./#" data-ref="%s">
                <span class="glyphicon glyphicon-folder-close"></span>
                <span class="node-label">%s</span></a>
                <!-- Tree Child nodes -->
            </div>
            <ul style="display: none">%s</ul>
        </li>
EOD;

const TREE_EMPTY_BRANCH_TPL = <<<'EOD'
        <li class="branch">
            <div id="%s"><a href="./#" data-ref="%s">
                <span class="glyphicon glyphicon-folder-close"></span>
                <span class="node-label">%s</span></a>
            </div>
        </li>
EOD;

const TREE_LEAF_TPL = <<<'EOD'
        <li class="leaf">
            <div id="%s"><a href="./#" data-ref="%s">
                <span class="glyphicon glyphicon-file"></span>
                <span class="node-label">%s</span></a>
            </div>
        </li>
EOD;

class Html
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
            return sprintf(TREE_BRANCH_TPL, $id, $text, $path, '%s');
        } elseif ($isDir) {
            return sprintf(TREE_EMPTY_BRANCH_TPL, $id, $path, $text);
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
                    self::$slugMappers[$node->getRealPath()]
                 );
            } else {
                $items[] = sprintf(
                    self::getNodeTemplate(
                        $node->getId(),
                        $node->getText(),
                        $node->hasChildren(),
                        $node->isDir(),
                        self::$slugMappers[$node->getRealPath()]
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

        if (!empty($items)) {
            return sprintf(TREE_TPL, implode('', $items));
        }

        return;
    }
}

