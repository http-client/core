<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\RelationalDatabaseService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://rds.aliyuncs.com';

    /**
     * @return void
     */
    protected function boot()
    {
        $this['database'] = function ($pimple) {
            return new Database($pimple);
        };
    }
}
