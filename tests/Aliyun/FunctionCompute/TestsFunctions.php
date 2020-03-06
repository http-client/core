<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait TestsFunctions
{
    public function testGetFunction()
    {
        $this->getClient()->getFunction('hello', 'world');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions/world', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/functions/world', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testGetFunctions()
    {
        $this->getClient()->getFunctions('hello');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/functions', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testCreateFunction()
    {
        $this->getClient()->createFunction('hello', [
            'code' => 'test', 'functionName' => 'foobar', 'handler' => 'weforge.net', 'runtime' => 'custom',
        ]);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/functions', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"code":"test","functionName":"foobar","handler":"weforge.net","runtime":"custom"}', (string) $this->request->getBody());
    }

    public function testUpdateFunction()
    {
        $this->getClient()->updateFunction('hello', 'world', [
            'code' => 'test', 'handler' => 'weforge.net', 'runtime' => 'custom',
        ]);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions/world', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('PUT', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/functions/world', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"code":"test","handler":"weforge.net","runtime":"custom"}', (string) $this->request->getBody());
    }

    public function testDeleteFunction()
    {
        $this->getClient()->deleteFunction('hello', 'world');

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions/world', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('DELETE', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/functions/world', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testInvokeFunction()
    {
        $this->getClient()->invokeFunction('hello', 'world', ['command' => 'rm -rf /']);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions/world/invocations', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], ['X-Fc-Invocation-Type' => 'Sync'], '/2016-08-15/services/hello/functions/world/invocations', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"command":"rm -rf \/"}', (string) $this->request->getBody());
    }

    public function testInvokeFunctionAsynchronously()
    {
        $this->getClient()->invokeFunctionAsynchronously('hello', 'world', ['command' => 'rm -rf /']);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/functions/world/invocations', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], ['X-Fc-Invocation-Type' => 'Async'], '/2016-08-15/services/hello/functions/world/invocations', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"command":"rm -rf \/"}', (string) $this->request->getBody());
    }
}
