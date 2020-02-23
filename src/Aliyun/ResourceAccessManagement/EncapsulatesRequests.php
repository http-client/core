<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Support\Str;

trait EncapsulatesRequests
{
    public function encapsulateRequest(array $params)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2015-05-01',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => Str::random(),
            'SignatureVersion' => '1.0',
            'AccessKeyId' => $this->options['access_key_id'],
            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
        ], $params);

        $query['Signature'] = (new RpcSignature($method = 'POST'))->sign($query, $this->options['access_key_secret']);

        return $this->request($method, '/', compact('query'));
    }
}
