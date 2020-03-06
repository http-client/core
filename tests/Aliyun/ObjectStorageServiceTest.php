<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun;

use HttpClient\Aliyun\ObjectStorageService;
use HttpClient\Aliyun\ObjectStorageServiceBucket;
use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Tests\ClientTestCase;

class ObjectStorageServiceTest extends ClientTestCase
{
    protected function getClient()
    {
        return (new ObjectStorageService([
            'access_key_id' => 'test-id',
            'access_key_secret' => 'test-secret',
        ]))->setBaseUri('https://oss-cn-shenzhen.aliyuncs.com');
    }

    public function testGetServices()
    {
        $this->getClient()->getServices();

        parse_str($this->request->getUri()->getQuery(), $query);

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/', $this->request->getUri()->getPath());
        $this->assertSame('oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('GET', '', '', $this->request->getHeader('Date')[0], [], '/', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
    }

    public function testBucket()
    {
        $bucket = $this->getClient()->bucket('hello');

        $this->assertInstanceOf(ObjectStorageServiceBucket::class, $bucket);
        $this->assertSame('https://hello.oss-cn-shenzhen.aliyuncs.com', $bucket->getBaseUri());
        $this->assertSame(['access_key_id' => 'test-id', 'access_key_secret' => 'test-secret'], $bucket->getOptions());

        // Http
        $this->assertSame('http://world.oss-cn-shanghai.aliyuncs.com', $this->getClient()->setBaseUri('http://oss-cn-shanghai.aliyuncs.com')->bucket('world')->getBaseUri());
    }
}
