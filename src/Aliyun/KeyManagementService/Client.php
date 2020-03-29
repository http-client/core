<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\KeyManagementService;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Core\Client as BaseClient;

class Client extends BaseClient
{
    public function request(array $params)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2016-01-20',
            'AccessKeyId' => $this->app['options']['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
        ], $params);

        $query['Signature'] = RpcSignature::sign($query, $this->app['options']['access_key_secret']);

        return $this->todotodo('POST', '/', [
            'query' => $query,
        ]);
    }
}
