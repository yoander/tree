<?php

namespace YVR\Util;

class ChangeManager
{
    private static $storage = null;

    private static $isInitialise = false;

    public static function init()
    {
        if (!self::$isInitialise) {
            self::$isInitialise = true;
            self::$storage = new \SplObjectStorage();
        }
    }

    public static function register(Subject $subject, Observer $observer)
    {
        if (!self::$isInitialise) {
            throw new \BadFunctionCallException('You must init the' .
                __CLASS__ . ' class before calling ' . __FUNCTION__ .
                ' method');
        }

        $subject->attach($observer);
        $observer->observe($subject);

        self::$storage->attach($subject);
    }

    public static function unregister(Subject $subject, Observer $observer)
    {
        if (!self::$isInitialise) {
            throw new \BadFunctionCallException('You must init the' .
                __CLASS__ . ' class before calling ' . __FUNCTION__ .
                ' method');
        }

        $subject->detach($observer);
    }

    public static function clean(Subject $subject = null)
    {
        if (!self::$isInitialise) {
            throw new \BadFunctionCallException('You must init the' .
                __CLASS__ . ' class before calling ' . __FUNCTION__ .
                ' method');
        }

        if (!is_null($subject)) {
            if (!self::$storage->offsetExists($subject)) {
                throw new \InvalidArgumentException('Subject is not
                    managed by ' . __CLASS__);
            }

            $subject->detachAll();
            self::$storage->detach($subject);
        } else {
            foreach (self::$storage as $subject) {
                $subject->detachAll();
                self::$storage->detach($subject);
            }
        }

        return true;
    }

    public static function notify(Subject $subject = null)
    {
        if (!self::$isInitialise) {
            throw new \BadFunctionCallException('You must init the' .
                __CLASS__ . ' class before calling ' . __FUNCTION__ .
                ' method');
        }


         if (!is_null($subject)) {
            if (!self::$storage->offsetExists($subject)) {
                throw new \InvalidArgumentException('Subject is not
                    managed by ' . __CLASS__);
            }

            $subject->notify();
        } else {
            foreach (self::$storage as $subject) {
                $subject->notify();
            }
        }
    }
}
