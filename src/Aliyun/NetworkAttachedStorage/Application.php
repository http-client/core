<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    protected $providers = [
        ServiceProvider::class,
    ];
}
