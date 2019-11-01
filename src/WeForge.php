<?php

declare(strict_types=1);

namespace WeForge;

use WeForge\Integrations\IntegratesWithLaravel;

class WeForge
{
    use IntegratesWithLaravel;

    /**
     * @var callable
     */
    public static $resolveCacheUsing;

    /**
     * @var callable
     */
    public static $resolveLoggerUsing;

    /**
     * @param callable $callback
     *
     * @return static
     */
    public static function resolveCacheUsing(callable $callback)
    {
        static::$resolveCacheUsing = $callback;

        return new static;
    }

    /**
     * @param callable $callback
     *
     * @return static
     */
    public static function resolveLoggerUsing(callable $callback)
    {
        static::$resolveLoggerUsing = $callback;

        return new static;
    }
}
