<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\DomainNameService;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Support\Str;

trait EncapsulatesRequests
{
    protected function encapsulateRequest(array $query)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2015-01-09',
            'AccessKeyId' => $this->options['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
        ], $query);

        $query['Signature'] = (new RpcSignature($method = 'POST'))
                                    ->sign($query, $this->options['access_key_secret']);

        return $this->request($method, '/', compact('query'));
    }
}
