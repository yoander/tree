<?php

namespace YVR\Util;

trait SingletonTrait
{
    protected static $instances = null;

    private function __clone() {}

    protected function __construct() {}

    public static function instance()
    {
        $classId = md5(get_called_class());

        if (empty(self::$instances[$classId])) {
            self::$instances[$classId] = new static();
        }

        return self::$instances[$classId];
    }
}
