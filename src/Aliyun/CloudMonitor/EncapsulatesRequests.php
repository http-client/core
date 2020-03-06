<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Support\Str;

trait EncapsulatesRequests
{
    public function encapsulateRequest(array $parameters)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2019-01-01',
            'AccessKeyId' => $this->options['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
        ], $parameters);

        $query['Signature'] = RpcSignature::sign($query, $this->options['access_key_secret']);

        return $this->send('POST', '/', compact('query'));
    }
}
