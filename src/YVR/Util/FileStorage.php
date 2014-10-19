<?php

namespace YVR\Util;

class FileStorage implements PersistentStorageInterface
{
    private $file;

    private $append = false;

    private $mode = 'w+';

    private $data = null;

    public function __construct($file, $data = null)
    {
        $this->file = $file;
        $this->data = $data;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function append($enable = true)
    {
        $this->append = $enable;

        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function save()
    {
        if ($this->append) {
            $this->mode = 'a+';
        }

        $this->data = serialize($this->data);

        $fp = fopen($this->file, $this->mode);
        $ok = fwrite($fp, $this->data);
        $ok = $ok && fclose($fp);

        return  $ok;
    }

    public function get()
    {
        return unserialize(file_get_contents($this->file));
    }
}
