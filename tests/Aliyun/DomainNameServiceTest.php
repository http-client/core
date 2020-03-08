<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun;

use HttpClient\Aliyun\DomainNameService;
use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Tests\ClientTestCase;

class DomainNameServiceTest extends ClientTestCase
{
    public function testRequest()
    {
        $client = new DomainNameService([
            'access_key_id' => 'test-access-key-id',
            'access_key_secret' => 'test-access-key-secret',
        ]);

        $response = $client->request([
            'Foo' => 'Bar',
        ]);

        parse_str($this->request->getUri()->getQuery(), $query);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('alidns.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/', $this->request->getUri()->getPath());

        $this->assertCount(9, $query);
        $this->assertSame('Bar', $query['Foo']);
        $this->assertSame('JSON', $query['Format']);
        $this->assertSame('2015-01-09', $query['Version']);
        $this->assertSame('test-access-key-id', $query['AccessKeyId']);
        $this->assertSame('HMAC-SHA1', $query['SignatureMethod']);
        $this->assertSame('1.0', $query['SignatureVersion']);
        $this->assertSame(16, strlen($query['SignatureNonce']));

        $this->assertSame($query['Signature'], RpcSignature::sign($query, 'test-access-key-secret'));
    }
}
