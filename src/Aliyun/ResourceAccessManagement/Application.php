<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://ram.aliyuncs.com';

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
