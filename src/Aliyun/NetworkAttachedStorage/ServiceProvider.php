<?php

namespace HttpClient\Aliyun\NetworkAttachedStorage;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['region'] = function ($pimple) {
            return new Region($pimple);
        };

        $pimple['filesystem'] = function ($pimple) {
            return new Filesystem($pimple);
        };

        $pimple['access_group'] = function ($pimple) {
            return new AccessGroup($pimple);
        };

        $pimple['access_rule'] = function ($pimple) {
            return new AccessRule($pimple);
        };

        $pimple['mount_target'] = function ($pimple) {
            return new MountTarget($pimple);
        };
    }
}
