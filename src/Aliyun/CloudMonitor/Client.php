<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Core\Client as BaseClient;
use HttpClient\Support\Str;

class Client extends BaseClient
{
    public function request(array $parameters)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2019-01-01',
            'AccessKeyId' => $this->app['options']['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
        ], $parameters);

        $query['Signature'] = RpcSignature::sign($query, $this->app['options']['access_key_secret']);

        return $this->send('POST', '/', compact('query'));
    }
}
