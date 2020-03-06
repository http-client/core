<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait TestsServices
{
    public function testGetService()
    {
        $this->getClient()->getService('hello');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }

    public function testGetServices()
    {
        $this->getClient()->getServices();

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }

    public function testCreateService()
    {
        $this->getClient()->createService(['serviceName' => 'foo']);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"serviceName":"foo"}', (string) $this->request->getBody());
    }

    public function testUpdateService()
    {
        $this->getClient()->updateService('foo', ['role' => 'foo/bar']);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('PUT', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"role":"foo\/bar"}', (string) $this->request->getBody());
    }

    public function testDeleteService()
    {
        $this->getClient()->deleteService('foo');

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('DELETE', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }
}
