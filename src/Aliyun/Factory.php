<?php

namespace HttpClient\Aliyun;

class Factory
{
    protected static $apps = [
        'objectStorageService' => ObjectStorageService\Application::class,
    ];

    public static function __callStatic(string $name, array $arguments)
    {
        $app = static::$apps[$name];

        return new $app(...$arguments);
    }
}
