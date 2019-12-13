<?php

declare(strict_types=1);

namespace WeForge\Support;

use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;
use WeForge\WeForge;

class Logger implements LoggerInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected static $resolvedLogger;

    /**
     * System is unusable.
     *
     * @param string $message
     *
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     *
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     *
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     *
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     *
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     *
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     *
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     *
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        $this->logger()->log($level, $message, $context);
    }

    /**
     * Resolve logger
     */
    public function logger(): LoggerInterface
    {
        if (static::$resolvedLogger) {
            return static::$resolvedLogger;
        }

        return static::$resolvedLogger = call_user_func(WeForge::$resolveLoggerUsing ?: function () {
            return new MonologLogger('WeForge');
        });
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        return (new static)->{$name}(...$args);
    }
}
