<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://vpc.aliyuncs.com';

    /**
     * @return void
     */
    protected function boot()
    {
        $this['switch'] = function ($pimple) {
            return new Switch($pimple);
        };
    }
}
