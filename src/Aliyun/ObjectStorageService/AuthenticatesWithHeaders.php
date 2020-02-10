<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Aliyun\CalculatesSignatureWithAlgoSha256;
use HttpClient\Aliyun\Helper;

trait AuthenticatesWithHeaders
{
    use CalculatesSignatureWithAlgoSha256;

    protected function authenticateWithHeaders($method, $resource)
    {
        $headers = [
            'Host' => $this->options['endpoint'],
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = '',
            'Content-Length' => '0',
        ];

        $headers['Authorization'] = sprintf(
            'OSS %s:%s', $this->options['access_key_id'], $this->calculateSignature($method, $contentType, $date, [], $resource, 'sha1')
        );

        return $headers;
    }

    protected function signForQueryString($method, $date, $resource)
    {
        return $this->calculateSignature($method, '', $date, [], $resource, 'sha1');
    }
}
