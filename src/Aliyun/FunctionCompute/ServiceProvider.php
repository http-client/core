<?php

namespace HttpClient\Aliyun\FunctionCompute;

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
        $pimple['service'] = function ($pimple) {
            return new Service($pimple);
        };

        $pimple['function'] = function ($pimple) {
            return new ServiceFunction($pimple);
        };

        $pimple['alias'] = function ($pimple) {
            return new Alias($pimple);
        };

        $pimple['trigger'] = function ($pimple) {
            return new Trigger($pimple);
        };

        $pimple['version'] = function ($pimple) {
            return new Version($pimple);
        };

        $pimple['domain'] = function ($pimple) {
            return new Domain($pimple);
        };
    }
}
