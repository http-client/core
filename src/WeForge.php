<?php

namespace WeForge;

class WeForge
{
    /**
     * Determine whether WeForge is running in Laravel framework.
     *
     * @var bool
     */
    public static $runningInLaravel = false;

    /**
     * @var callable
     */
    public static $resolveCacheUsing;

    /**
     * @param callable $callback
     *
     * @return static
     */
    public static function resolveCacheUsing(callable $callback)
    {
        static::$resolveCacheUsing = $callable;

        return new static;
    }
}
