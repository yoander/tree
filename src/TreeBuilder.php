<?php

namespace Tree;

use Tree\Util\NodeRegistry as NodeRegistry;
use Tree\Util\NodeObserver as NodeObserver;
use Voltus\Pattern\ChangeManager;

class TreeBuilder
{
    private $path = '';

    private $recursive = false;

    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function create()
    {
        if ($this->recursive) {
            $dit = new \RecursiveDirectoryIterator($this->path,
            \FilesystemIterator::CURRENT_AS_FILEINFO |
            \FilesystemIterator::SKIP_DOTS);

            $it = new \RecursiveIteratorIterator($dit,
                \RecursiveIteratorIterator::SELF_FIRST);
        } else {
            $it =  new \FilesystemIterator($this->path,
            \FilesystemIterator::CURRENT_AS_FILEINFO |
            \FilesystemIterator::SKIP_DOTS);
        }

        ChangeManager::init();

        foreach ($it as $file) {
            $node = new Node($file, $this->path);
            ChangeManager::register($node, new NodeObserver());
            NodeRegistry::instance()->add($node->getId(), $node);
        }

        ChangeManager::notify();

        return $this;
    }

    protected function sortByName()
    {
        $arr = NodeRegistry::instance()->getArray();

        uasort($arr, function (Node $a, Node $b) {
            if ($a->isDir() && $b->isFile()) {
                return -1;
            } else if ($a->isFile() && $b->isDir()) {
                return 1;
            } else {
                return strcasecmp($a->getRealPath(), $b->getRealPath());
            }
        });

        return $arr;
    }

    public function recursive($recursive = true)
    {
        $this->recursive = $recursive;

        return $this;
    }

    public function get()
    {
        $this->create();
        $tree = [];

        if (NodeRegistry::instance()->hasElements()) {
            $sorted = $this->sortByName();

            foreach ($sorted as $node) {
                if ($this->path == $node->getPath()) { // Root node
                    $tree[] = $node;
                } else { // Insert child node under parent node
                    $parentNode = NodeRegistry::instance()
                        ->get($node->getParentId());
                    $parentNode->addChild($node);
                }
            }
        }

        return $tree;
    }

    public function findNode($id)
    {
        return NodeRegistry::instance()->get($id);
    }
}
