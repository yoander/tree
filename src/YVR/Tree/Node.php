<?php

namespace YVR\Tree;

use YVR\Util\Subject as Observable;

/**
 * Represent a node in the Tree
 */
class Node extends Observable
{
    private $node = null;

    private $rootPath = '';

    /**
     * Represent an array of child
     *
     * @var ArrayIterator $children
     */
    private $children = null;

    public function __construct(\SplFileInfo $node, $rootPath = '')
    {
        parent::__construct();
        $this->node = $node;
        $this->rootPath = $rootPath;
        $this->children = new \ArrayIterator([]);
    }

    public function getId()
    {
        return md5($this->node->getRealPath());
    }

    public function getText()
    {
        return $this->node->getBasename('.' . $this->getExtension());
    }

    public function getName()
    {
        return $this->node->getFilename();
    }

    public function getInternalPath()
    {
        $basePath = str_replace($this->rootPath, '', $this->getPath());
        return $basePath . $this->getText();
    }

    public function getExtension()
    {
        return $this->node->getExtension();
    }

    public function addChild(Node $node)
    {
        $this->children->offsetSet($node->getId(), $node);
    }

    public function isFile()
    {
        return $this->node->isFile();
    }

    public function isDir()
    {
        return $this->node->isDir();
    }

    public function getPath()
    {
        return $this->node->getPath();
    }

    public function getPathName()
    {
        return $this->node->getPathname();
    }

    public function getRealPath()
    {
        return $this->node->getRealpath();
    }

    public function getParentId()
    {
        return md5($this->node->getPathInfo()->getRealPath());
    }

    public function hasChildren()
    {
        return $this->children->count();
    }

    public function getChildren()
    {
        return $this->children;
    }

}
