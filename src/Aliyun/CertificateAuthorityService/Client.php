<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Core\Client as BaseClient;
use HttpClient\Support\Str;

class Client extends BaseClient
{
    public function request(array $params)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2018-07-13',
            'AccessKeyId' => $this->app['options']['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => Str::random(),
            'ResourceOwnerAccount' => null,
        ], $params);

        $query['Signature'] = RpcSignature::sign($query, $this->app['options']['access_key_secret']);

        return $this->send('POST', '/', compact('query'));
    }

    // public function request20180813(array $params)
    // {
    //     return $this->request(array_merge($params, [
    //         'Version' => '2018-08-13',
    //     ]));
    // }
}
