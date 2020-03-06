<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait TestsVersions
{
    public function testGetVersions()
    {
        $this->getClient()->getVersions('foo');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/versions', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/versions', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }

    public function testPublishVersions()
    {
        $this->getClient()->publishVersion('foo');

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/versions', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/versions', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"description":null}', (string) $this->request->getBody());
    }

    public function testPublishVersionsWithDescription()
    {
        $this->getClient()->publishVersion('foo', 'hello');

        $this->assertSame('{"description":"hello"}', (string) $this->request->getBody());
    }

    public function testDeleteVersion()
    {
        $this->getClient()->deleteVersion('foo', 10);

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/versions/10', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('DELETE', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/versions/10', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }
}
