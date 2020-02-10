<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Support\Str;

trait EncapsulatesRequests
{
    protected function encapsulateRequest(array $params)
    {
        $query = array_merge([
            'AccessKeyId' => $this->options['access_key_id'],
            'Format' => 'JSON',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => Str::random(),
            'SignatureVersion' => '1.0',
            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
            'Version' => '2016-04-28',
        ], $params);

        $query['Signature'] = (new RpcSignature($method = 'POST'))
                                    ->sign($query, $this->options['access_key_secret']);

        return $this->request($method, '/', compact('query'));
    }
}
