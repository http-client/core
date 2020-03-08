<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Support\Str;

trait EncapsulatesRequests
{
    public function request(array $query)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2017-06-26',
            'AccessKeyId' => $this->options['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
        ], $query);

        $query['Signature'] = RpcSignature::sign($query, $this->options['access_key_secret']);

        return $this->send('POST', '/', compact('query'));
    }
}
