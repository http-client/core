<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

use HttpClient\Aliyun\Concerns\CalculatesAuthorizationSignature;
use HttpClient\Core\Client as BaseClient;

class Client extends BaseClient
{
    use CalculatesAuthorizationSignature;

    public function request(string $method, string $resource, array $options = [])
    {
        $headers = [
            'Host' => $this->options['endpoint'],
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = 'text/xml',
            'Content-Length' => '0',
            'x-mns-version' => '2015-06-06',
        ];

        $headers['Authorization'] = 'MNS '.$this->options['access_key_id'].':'.$this->calculateAuthorizationSignature(
            $method, '', $contentType, $date, ['x-mns-version' => '2015-06-06'], $resource
        );

        return $this->request($method, $resource, array_merge([
            'headers' => $headers,
        ], $options));
    }
}
