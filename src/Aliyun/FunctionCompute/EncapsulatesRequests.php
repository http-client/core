<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Concerns\CalculatesAuthorizationSignature;

trait EncapsulatesRequests
{
    use CalculatesAuthorizationSignature;

    protected function requestResource($method, $resource, array $options = [], array $canonicalizedHeaders = [])
    {
        if (isset($this->options['security_token'])) {
            $canonicalizedHeaders = array_merge($canonicalizedHeaders, ['x-fc-security-token' => $this->options['security_token']]);
        }
        $contentMd5 = '';

        $headers = [
            'Host' => $this->options['endpoint'],
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Content-Type' => $contentType = 'application/json',
            'Content-Length' => '0',
            // 'Content-MD5' => '',
        ] + $canonicalizedHeaders;

        $signature = $this->calculateAuthorizationSignatureWithSha256($method, $contentMd5, $contentType, $date, $canonicalizedHeaders, $resource);

        $headers['Authorization'] = sprintf('FC %s:%s', $this->options['access_key_id'], $signature);

        return $this->request($method, $resource, array_merge(
            ['headers' => $headers], $options
        ));
    }
}
