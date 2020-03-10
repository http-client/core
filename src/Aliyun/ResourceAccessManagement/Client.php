<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Core\Client as BaseClient;
use HttpClient\Support\Str;

class Client extends BaseClient
{
    public function request(array $params)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2015-05-01',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => Str::random(),
            'SignatureVersion' => '1.0',
            'AccessKeyId' => $this->app['options']['access_key_id'],
            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
        ], $params);

        $query['Signature'] = RpcSignature::sign($query, $this->app['options']['access_key_secret']);

        return $this->send('POST', '/', compact('query'));
    }
}
