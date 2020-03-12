<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Core\Client as BaseClient;
use HttpClient\Support\Str;

class Client extends BaseClient
{
    public function request(array $params)
    {
        $query = array_merge([
            'AccessKeyId' => $this->app['options']['access_key_id'],
            'Format' => 'JSON',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => Str::random(),
            'SignatureVersion' => '1.0',
            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
            'Version' => '2016-04-28',
        ], $params);

        $query['Signature'] = RpcSignature::sign($query, $this->app['options']['access_key_secret']);

        return $this->send('POST', '/', compact('query'));
    }
}
