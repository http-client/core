<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Helper;

trait NeedsAuthentication
{
    protected function xxrequestResource($method, $resource)
    {
        $contentMd5 = '';

        $headers = [
            'Host' => $this->options['endpoint'],
            'Date' => $date = Helper::gmdate(),
            'Content-Type' => $contentType = 'application/json',
            'Content-Length' => '0',
        ];

        $signature = $this->calculateAuthorizationSignatureWithSha256($method, $contentMd5, $contentType, $date, [], $resource);

        $headers['Authorization'] = sprintf('FC %s:%s', $this->options['access_key_id'], $signature);

        return $this->request($method, $resource, compact('headers'));
    }

    protected function xxgetAuthenticationHeaders($method, $contentType = 'application/json', array $canonicalizedHeaders = [], string $canonicalizedResource = '/', array $canonicalizedResourceQuery = [])
    {
        $headers = [
            'Host' => $this->options['endpoint'],
            'Date' => $date = Helper::gmdate(),
            'Content-Type' => $contentType,
            'Content-Length' => '0',
            // 'Content-MD5' => '',
        ];

        if (!empty($canonicalizedResourceQuery)) {
            $params = [];
            foreach ($canonicalizedResourceQuery as $key => $values) {
                if (is_scalar($values)) {
                    $params[] = sprintf('%s=%s', $key, $values);
                    continue;
                }
                if (count($values) > 0) {
                    foreach ($values as $value) {
                        $params[] = sprintf('%s=%s', $key, $value);
                    }
                } else {
                    $params[] = strval($key);
                }
            }
            ksort($params);

            $canonicalizedResource = $canonicalizedResource."\n".implode("\n", $params);
            // dd($canonicalizedResource);
        }

        $headers['Authorization'] = sprintf(
            'FC %s:%s', $this->options['access_key_id'], $this->calculateSignature($method, $contentType, $date, $canonicalizedHeaders, $canonicalizedResource)
        );

        return $headers + $canonicalizedHeaders;
    }
}
