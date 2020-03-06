<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait TestsTriggers
{
    public function testGetTrigger()
    {
        $this->getClient()->getTrigger('foo', 'bar', 'baz');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/functions/bar/triggers/baz', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/functions/bar/triggers/baz', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }

    public function testGetTriggers()
    {
        $this->getClient()->getTriggers('foo', 'bar');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/functions/bar/triggers', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/functions/bar/triggers', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }

    public function testCreateTrigger()
    {
        $this->getClient()->createTrigger('foo', 'bar', ['triggerType' => 'test']);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/functions/bar/triggers', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/functions/bar/triggers', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"triggerType":"test"}', (string) $this->request->getBody());
    }

    public function testUpdateTrigger()
    {
        $this->getClient()->updateTrigger('foo', 'bar', 'baz', ['triggerType' => 'test']);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/functions/bar/triggers/baz', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('PUT', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/functions/bar/triggers/baz', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"triggerType":"test"}', (string) $this->request->getBody());
    }

    public function testDeleteTrigger()
    {
        $this->getClient()->deleteTrigger('foo', 'bar', 'baz');

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/foo/functions/bar/triggers/baz', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('DELETE', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/foo/functions/bar/triggers/baz', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('', (string) $this->request->getBody());
    }
}
