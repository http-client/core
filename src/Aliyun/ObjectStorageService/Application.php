<?php

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Core\Application as BaseApplication;
use HttpClient\Aliyun\ObjectStorageServiceBucket\Application as ObjectStorageServiceBucket;

class Application extends BaseApplication
{
    protected $providers = [
        ServiceProvider::class,
    ];

    public function bucket($name)
    {
        $parsed = parse_url($this->getBaseUri());

        $baseUri = sprintf('%s://%s', $parsed['scheme'], $name.'.'.$parsed['host']);

        return new ObjectStorageServiceBucket(
            array_merge($this->options, ['bucket' => $name, 'http' => ['base_uri' => $baseUri]])
        );
    }
}
