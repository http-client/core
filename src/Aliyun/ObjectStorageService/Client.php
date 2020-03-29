<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Core\Client as BaseClient;
use HttpClient\Support\Arr;

class Client extends BaseClient
{
    public function request($method, $resource, array $options = [])
    {
        $headers = [
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = 'text/plain',
            // 'Content-Length' => '0',
        ];

        $ch = array_filter(Arr::startsWith($options['headers'] ?? [], 'x-oss-'));

        $headers = array_merge($headers, $ch);

        $headers['Authorization'] = sprintf(
            'OSS %s:%s', $this->app['options']['access_key_id'], AuthorizationSignature::sign($method, '', $contentType, $date, $ch, (isset($this->app['options']['bucket']) ? '/'.$this->app['options']['bucket'] : '').$resource, $this->app['options']['access_key_secret'])
        );

        return $this->todotodo($method, $resource, [
            'headers' => $headers,
        ]);
    }
}
