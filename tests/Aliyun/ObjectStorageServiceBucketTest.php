<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun;

use HttpClient\Aliyun\ObjectStorageServiceBucket;
use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Tests\ClientTestCase;

class ObjectStorageServiceBucketTest extends ClientTestCase
{
    protected function getClient()
    {
        return (new ObjectStorageServiceBucket([
            'access_key_id' => 'test-id',
            'access_key_secret' => 'test-secret',
        ]))->setBaseUri('https://hello.oss-cn-shenzhen.aliyuncs.com');
    }

    public function testInfo()
    {
        $this->getClient()->getInfo();

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(1, $query);
        $this->assertSame('', $query['bucketInfo']);

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('GET', '', '', $this->request->getHeader('Date')[0], [], '/hello/?bucketInfo', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
    }

    public function testCreateBucket()
    {
        $this->getClient()->createBucket();

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(0, $query);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('PUT', '', '', $this->request->getHeader('Date')[0], [], '/hello/', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );

        // Http
        $this->getClient()->setBaseUri('http://hello.oss-cn-shenzhen.aliyuncs.com')->createBucket();

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(0, $query);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('http', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('PUT', '', '', $this->request->getHeader('Date')[0], [], '/hello/', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
    }

    public function testDeleteBucket()
    {
        $this->getClient()->deleteBucket('foo');

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(0, $query);

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('DELETE', '', '', $this->request->getHeader('Date')[0], [], '/hello/', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
    }

    public function testHeadObject()
    {
        $this->getClient()->headObject('test');

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(0, $query);

        $this->assertSame('HEAD', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/test', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('HEAD', '', '', $this->request->getHeader('Date')[0], [], '/hello/test', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
    }

    public function testGetObject()
    {
        $this->getClient()->getObject('test');

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(0, $query);

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/test', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('GET', '', '', $this->request->getHeader('Date')[0], [], '/hello/test', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
    }

    public function testPutObject()
    {
        $this->getClient()->putObject('test', 'content-string');

        parse_str($this->request->getUri()->getQuery(), $query);
        $this->assertCount(0, $query);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/test', $this->request->getUri()->getPath());
        $this->assertSame('hello.oss-cn-shenzhen.aliyuncs.com', $this->request->getHeader('Host')[0]);
        $this->assertSame('', $this->request->getHeader('Content-Type')[0]);
        $this->assertSame('0', $this->request->getHeader('Content-Length')[0]);
        $this->assertSame(
            'OSS test-id:'.AuthorizationSignature::sign('PUT', '', '', $this->request->getHeader('Date')[0], [], '/hello/test', 'test-secret'),
            $this->request->getHeader('Authorization')[0]
        );
        $this->assertSame('content-string', (string) $this->request->getBody());
    }
}
