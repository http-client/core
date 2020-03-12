<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['service'] = function ($pimple) {
            return new Service($pimple);
        };

        $this['function'] = function ($pimple) {
            return new ServiceFunction($pimple);
        };

        $this['alias'] = function ($pimple) {
            return new Alias($pimple);
        };

        $this['trigger'] = function ($pimple) {
            return new Trigger($pimple);
        };

        $this['version'] = function ($pimple) {
            return new Version($pimple);
        };

        $this['domain'] = function ($pimple) {
            return new Domain($pimple);
        };
    }
}
