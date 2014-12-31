<?php

namespace Tree\Helper;

class Output
{
    const TYPE_TREE = 'TYPE_TREE';

    const TYPE_CONTENT = 'TYPE_CONTENT';

    private $type = self::TYPE_TREE;

    private $contentType = self::TYPE_TREE;

    private $raw = null;

    public function __construct($raw, $type = self::TYPE_TREE, $contentType = null)
    {
        $this->raw = $raw;
        $this->type = $type;
        $this->contentType = $contentType;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    private function raw()
    {
        return $this->raw;
    }

    public function getContent()
    {
        return $this->raw();
    }

    public function getTree()
    {
        return $this->raw();
    }
}
