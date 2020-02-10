<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\SecurityTokenService;

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
            'Version' => '2015-04-01',
        ], $params);
        // dd($query);
        $query['Signature'] = (new RpcSignature($method = 'GET'))
                                    ->sign($query, $this->options['access_key_secret']);
// dd($query);

        return $this->request($method, '', compact('query'));
    }
}
