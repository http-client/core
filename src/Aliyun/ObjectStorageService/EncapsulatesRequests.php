<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Aliyun\CalculatesSignatureWithAlgoSha256;
use HttpClient\Aliyun\ObjectStorageServiceBucket;
use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait EncapsulatesRequests
{
    // use CalculatesSignatureWithAlgoSha256;

    public function encapsulateRequest($method, $resource, array $options = [])
    {
        $headers = [
            // 'Host' => $this->options['endpoint'],
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = '',
            'Content-Length' => '0',
        ];

        $headers['Authorization'] = sprintf(
            'OSS %s:%s', $this->options['access_key_id'], AuthorizationSignature::sign($method, '', $contentType, $date, [], ($this instanceof ObjectStorageServiceBucket ? '/'.$this->getBucketName() : '').$resource, $this->options['access_key_secret'])
        );

        return $this->send($method, $resource, array_merge([
            'headers' => $headers,
        ], $options));
    }

    protected function signForQueryString($method, $date, $resource)
    {
        return AuthorizationSignature::sign($method, '', '', $date, [], $resource, $this->options['access_key_secret']);
    }
}
