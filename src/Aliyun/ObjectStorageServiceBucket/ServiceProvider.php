<?php

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

use HttpClient\Aliyun\ObjectStorageService\Client;
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
        $pimple['client'] = function ($pimple) {
            return new Client($pimple);
        };

        $pimple['object'] = function ($pimple) {
            return new BucketObject($pimple);
        };
    }
}
