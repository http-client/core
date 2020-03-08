<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

use HttpClient\Aliyun\CalculatesSignatureWithAlgoSha256;
use HttpClient\Aliyun\Concerns\CalculatesAuthorizationSignature;
use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait EncapsulatesRequests
{
    // use CalculatesAuthorizationSignature;

    protected function request($method, $resource, array $json = [])
    {
        $ch = [
            'x-log-apiversion' => '0.6.0',
            'x-log-signaturemethod' => 'hmac-sha1',
            'x-log-bodyrawsize' => '0',
        ];

        $contentType = $contentMD5 = '';
        $headers = [
            // 'Host' => $this->options['endpoint'],
            'Date' => $date = gmdate('D, d M Y H:i:s T'),
            // 'Content-Type' => $contentType = empty($json) ? '' : 'application/json',
            // 'Content-Length' => empty($json) ? '' : strlen(json_encode($json)),
            // 'Content-MD5' => $contentMD5 = empty($json) ? '' : strtoupper(md5(json_encode($json))),
        ] + $ch;

        if (!empty($json)) {
            $headers['Content-Type'] = $contentType = 'application/json';
            $headers['Content-Length'] = strlen(json_encode($json));
            $headers['Content-MD5'] = $contentMD5 = strtoupper(md5(json_encode($json)));
        }
        $headers['Authorization'] = sprintf('LOG %s:%s', $this->options['access_key_id'], AuthorizationSignature::sign($method, $contentMD5, $contentType, $date, $ch, $resource, $this->options['access_key_secret']));

        // $headers['Authorization'] = 'LOG '.$this->options['access_key_id'].':'.$this->calculateAuthorizationSignature(
        //     $method, $contentMD5, $contentType, $date, $ch, $resource
        // );

        return $this->send($method, $resource, [
            'headers' => $headers,
            'body' => empty($json) ? null : json_encode($json),
        ]);
    }

    // use CalculatesSignatureWithAlgoSha256;

    // protected function requestWithAuthorization(string $method, string $resource, array $query = [], array $headers = [], $body = null)
    // {
    //     // $headers = $this->authenticateWithHeaders('GET', $resource = "/logstores/{$logstoreName}?".http_build_query($query), $query);
    //     $headers = $this->authenticateWithHeaders($method, $resource, $query, $headers);

    //     return $this->request($method, $resource, ['query' => $query, 'headers' => $headers, 'body' => $body]);
    // }

    // protected function authenticateWithHeaders($method, $resource, $canonicalizedResourceQuery = [], array $headers = [])
    // {
    //     $str = '';
    //     if ($canonicalizedResourceQuery) {
    //         [$_, $str] = $this->handleResourceQuery($canonicalizedResourceQuery);
    //     }

    //     $contentType = '';
    //     $canonicalizedHeaders = [
    //         'x-log-apiversion' => '0.6.0',
    //         // 'x-log-bodyrawsize' => '0',
    //         // 'x-log-compresstype' => 'lz4',
    //         'x-log-signaturemethod' => 'hmac-sha1',
    //     ];

    //     $headers = array_merge([
    //         'Accept' => 'application/json',
    //         'Accept-Encoding' => null,
    //         // 'Content-Length' => '0',
    //         // 'Content-MD5' => '',
    //         // 'Content-Type' => 'application/x-protobuf',
    //         'Date' => $date = gmdate('D, d M Y H:i:s T'),
    //         'Host' => $this->options['endpoint'],
    //     ], $canonicalizedHeaders, $headers);

    //     $headers['Authorization'] = sprintf(
    //         'LOG %s:%s', $this->options['access_key_id'], $this->calculateSignature($method, $contentType, $date, $canonicalizedHeaders, $resource.'?'.$str, 'sha1')
    //         // 'LOG %s:%s', $this->options['access_key_id'], $this->calculateSignature($method, $contentType, $date, $canonicalizedHeaders, '/logstores/idontknow?'.$str, 'sha1')
    //     );

    //     return $headers;
    // }

    // protected function handleResourceQuery(array $query)
    // {
    //     $query = array_filter($query);
    //     ksort($query);

    //     $canonicalizedQueryString = '';

    //     foreach ($query as $key => $value) {
    //         $canonicalizedQueryString .= '&'.$key.'='.$value;
    //     }

    //     return [
    //         $query, substr($canonicalizedQueryString, 1),
    //     ];
    // }
}
