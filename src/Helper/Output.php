<?php

namespace Tree\Helper;

class Output
{
    const TYPE_TREE = 'TYPE_TREE';

    const TYPE_CONTENT = 'TYPE_CONTENT';

    private $type = self::TYPE_TREE;

    private $raw = null;

    public function __construct($raw, $type = self::TYPE_TREE)
    {
        $this->raw = $raw;
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
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
