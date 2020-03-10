<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\SecurityTokenService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['role'] = function ($pimple) {
            return new Role($pimple);
        };
    }
}
