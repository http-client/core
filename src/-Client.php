<?php

declare(strict_types=1);

namespace WeClient;

// use WeForge\Integrations\IntegratesWithLaravel;

class Clientxxx
{
    // use IntegratesWithLaravel;

    /**
     * @var callable
     */
    public static $resolveCacheUsing;

    /**
     * @var callable
     */
    public static $resolveLoggerUsing;

    /**
     * @return static
     */
    public static function resolveCacheUsing(callable $callback)
    {
        static::$resolveCacheUsing = $callback;

        return new static;
    }

    /**
     * @return static
     */
    public static function resolveLoggerUsing(callable $callback)
    {
        static::$resolveLoggerUsing = $callback;

        return new static;
    }
}
