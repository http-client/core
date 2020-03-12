<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Core\Client as BaseClient;

class Client extends BaseClient
{
    public function request(string $method, string $resource, array $options = [])
    {
        $headers = [
            // 'Host' => $this->app['options']['endpoint'],
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = 'text/xml',
            // 'Content-Length' => '0',
            'x-mns-version' => '2015-06-06',
        ];

        $headers['Authorization'] = 'MNS '.$this->app['options']['access_key_id'].':'.AuthorizationSignature::sign($method, '', $contentType, $date, ['x-mns-version' => '2015-06-06'], $resource, $this->app['options']['access_key_secret']);

        // $headers['Authorization'] = 'MNS '.$this->options['access_key_id'].':'.$this->calculateAuthorizationSignature(
        //     $method, '', $contentType, $date, ['x-mns-version' => '2015-06-06'], $resource
        // );

        return $this->todotodo($method, $resource, array_merge([
            'headers' => $headers,
        ], $options));
    }
}
