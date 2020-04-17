<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\KeyValueStore;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://r-kvstore.aliyuncs.com';

    /**
     * @return void
     */
    protected function boot()
    {
        $this['instance'] = function ($app) {
            return new Instance($app);
        };

        $this['zone'] = function ($app) {
            return new Zone($app);
        };
    }
}
