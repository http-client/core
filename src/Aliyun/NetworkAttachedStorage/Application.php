<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @return array
     */
    protected function boot()
    {
        $this['region'] = function ($pimple) {
            return new Region($pimple);
        };

        $this['zone'] = function ($pimple) {
            return new Zone($pimple);
        };

        $this['filesystem'] = function ($pimple) {
            return new Filesystem($pimple);
        };

        $this['access_group'] = function ($pimple) {
            return new AccessGroup($pimple);
        };

        $this['access_rule'] = function ($pimple) {
            return new AccessRule($pimple);
        };

        $this['mount_target'] = function ($pimple) {
            return new MountTarget($pimple);
        };
    }
}
