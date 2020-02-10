<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

use HttpClient\Aliyun\Concerns\MakesRpcRequests;
use HttpClient\Concerns\GeneratesRandomString;

trait EncapsulatesRequests
{
    use MakesRpcRequests, GeneratesRandomString;

    protected function encapsulatesRequest(array $query)
    {
        $query = array_merge([
            'Format' => 'JSON',
            'Version' => '2017-06-26',
            'AccessKeyId' => $this->options['access_key_id'],
            'SignatureMethod' => 'HMAC-SHA1',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce' => $this->generateRandomString(),
        ], $query);

        $query['Signature'] = $this->computeSignature($query, $this->options['access_key_secret']);

        return $this->request('POST', '', compact('query'));
    }
}
