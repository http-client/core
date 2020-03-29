<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\KeyManagementService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['secret'] = function ($pimple) {
            return new Secret($pimple);
        };
    }
}
