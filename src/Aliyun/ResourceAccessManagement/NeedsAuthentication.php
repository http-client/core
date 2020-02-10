<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

use HttpClient\Aliyun\CalculatesSignatureApple;
use HttpClient\Support\Str;

trait NeedsAuthentication
{
    use CalculatesSignatureApple;

    protected function mergeDefaultAuthenticationAttributes(array $attributes = [])
    {
        return array_merge([
            'Format' => 'JSON',
            'Version' => '2015-05-01',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => Str::random(),
            'SignatureVersion' => '1.0',
            'AccessKeyId' => $this->options['access_key_id'],
            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
        ], $attributes);
    }
}
