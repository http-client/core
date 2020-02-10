<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Support\Str;

trait EncapsulatesRequests
{
    protected function encapsulateRequest(array $params)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2018-07-13',
            'AccessKeyId' => $this->options['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
            'ResourceOwnerAccount' => null,
        ], $params);

        $query['Signature'] = (new RpcSignature($method = 'GET'))->sign($query, $this->options['access_key_secret']);

        return $this->request($method, '', compact('query'));
    }

    protected function encapsulateRequest20180813(array $params)
    {
        return $this->encapsulateRequest(array_merge($params, [
            'Version' => '2018-08-13',
        ]));
    }
}
