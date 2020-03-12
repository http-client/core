<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\DomainNameService;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Core\Client as BaseClient;
use HttpClient\Support\Str;

class Client extends BaseClient
{
    public function request(array $query)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2015-01-09',
            'AccessKeyId' => $this->app['options']['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
        ], $query);

        $query['Signature'] = RpcSignature::sign($query, $this->app['options']['access_key_secret']);

        return $this->todotodo('POST', '/', compact('query'));
    }
}
