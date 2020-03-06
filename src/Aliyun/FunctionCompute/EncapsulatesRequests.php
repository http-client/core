<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait EncapsulatesRequests
{
    public function encapsulateRequest($method, $resource, array $options = [], array $canonicalizedHeaders = [])
    {
        if (isset($this->options['security_token'])) {
            $canonicalizedHeaders = array_merge($canonicalizedHeaders, ['x-fc-security-token' => $this->options['security_token']]);
        }
        $contentMd5 = '';

        $headers = [
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = 'application/json',
            'Content-Length' => '0',
            // 'Content-MD5' => '',
        ] + $canonicalizedHeaders;

        $signature = AuthorizationSignature::sign($method, $contentMd5, $contentType, $date, $canonicalizedHeaders, $resource, $this->options['access_key_secret'], 'sha256');

        $headers['Authorization'] = sprintf('FC %s:%s', $this->options['access_key_id'], $signature);

        return $this->send($method, $resource, array_merge(
            ['headers' => $headers], $options
        ));
    }
}
