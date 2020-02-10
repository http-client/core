<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

use HttpClient\Aliyun\CalculatesSignatureWithAlgoSha256;

trait Sign
{
    use CalculatesSignatureWithAlgoSha256;

    protected function requestWithAuthorization(string $method, string $resource, array $query = [], array $headers = [], $body = null)
    {
        // $headers = $this->authenticateWithHeaders('GET', $resource = "/logstores/{$logstoreName}?".http_build_query($query), $query);
        $headers = $this->authenticateWithHeaders($method, $resource, $query, $headers);

        return $this->request($method, $resource, ['query' => $query, 'headers' => $headers, 'body' => $body]);
    }

    protected function authenticateWithHeaders($method, $resource, $canonicalizedResourceQuery = [], array $headers = [])
    {
        $str = '';
        if ($canonicalizedResourceQuery) {
            [$_, $str] = $this->handleResourceQuery($canonicalizedResourceQuery);
        }

        $contentType = '';
        $canonicalizedHeaders = [
            'x-log-apiversion' => '0.6.0',
            // 'x-log-bodyrawsize' => 65,
            // 'x-log-compresstype' => 'lz4',
            'x-log-signaturemethod' => 'hmac-sha1',
        ];

        $headers = array_merge([
            'Accept' => 'application/json',
            'Accept-Encoding' => null,
            // 'Content-Length' => '0',
            // 'Content-MD5' => '',
            // 'Content-Type' => 'application/x-protobuf',
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            'Host' => $this->options['endpoint'],
        ], $canonicalizedHeaders, $headers);

        $headers['Authorization'] = sprintf(
            'LOG %s:%s', $this->options['access_key_id'], $this->calculateSignature($method, $contentType, $date, $canonicalizedHeaders, $resource.'?'.$str, 'sha1')
            // 'LOG %s:%s', $this->options['access_key_id'], $this->calculateSignature($method, $contentType, $date, $canonicalizedHeaders, '/logstores/idontknow?'.$str, 'sha1')
        );

        return $headers;
    }

    protected function handleResourceQuery(array $query)
    {
        $query = array_filter($query);
        ksort($query);

        $canonicalizedQueryString = '';

        foreach ($query as $key => $value) {
            $canonicalizedQueryString .= '&'.$key.'='.$value;
        }

        return [
            $query, substr($canonicalizedQueryString, 1),
        ];
    }
}
