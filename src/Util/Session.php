<?php

namespace Tree\Util;

class Session
{
    use SingletonTrait;

    const NONE = 'NONE';

    const DISABLED = 'DISABLED';

    const ACTIVE = 'ACTIVE';

    protected function __construct()
    {
        if (!$this->isActive()) {
            session_start();
        }
    }

    public function set($key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get($key)
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function isActive()
    {
        return self::ACTIVE === $this->status();
    }

    public function status()
    {
        if (function_exists('session_status')) {
            switch (session_status()) {
                case PHP_SESSION_ACTIVE: return self::ACTIVE;
                case PHP_SESSION_DISABLED: return self::DISABLED;
                case PHP_SESSION_NONE: return self::NONE;
            }
        } else {
            return session_id() === '' ? self::NONE : PHP_SESSION_ACTIVE;
        }
    }

    public function __destruct()
    {
        session_write_close ();
    }

}
