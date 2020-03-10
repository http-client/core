<?php

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Core\Client as BaseClient;

class Client extends BaseClient
{
    public function request($method, $resource, array $options = [])
    {
        $headers = [
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = 'text/plain',
            // 'Content-Length' => '0',
        ];

        $headers['Authorization'] = sprintf(
            'OSS %s:%s', $this->app['options']['access_key_id'], AuthorizationSignature::sign($method, '', $contentType, $date, [], ($this instanceof \HttpClient\Aliyun\ObjectStorageService\Client ? '/'.$this->app['options']['bucket'] : '').$resource, $this->app['options']['access_key_secret'])
        );

        return $this->send($method, $resource, array_merge([
            'headers' => $headers,
        ], $options));
    }
}
