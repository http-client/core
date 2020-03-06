<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait TestsAliases
{
    public function testGetAlias()
    {
        $this->getClient()->getAlias('hello', 'world');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/aliases/world', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/aliases/world', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testGetAliases()
    {
        $this->getClient()->getAliases('hello');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/aliases', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/aliases', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testCreateAlias()
    {
        $this->getClient()->createAlias('hello', 'world', 10);

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/aliases', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/aliases', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"aliasName":"world","versionId":"10","description":null,"additionalVersionWeight":null}', (string) $this->request->getBody());
    }

    public function testCreateAliasPassingAllParams()
    {
        $this->getClient()->createAlias('hello', 'world', 10, 'hello-world', 40);
        $this->assertSame('{"aliasName":"world","versionId":"10","description":"hello-world","additionalVersionWeight":40}', (string) $this->request->getBody());
    }

    public function testUpdateAlias()
    {
        $this->getClient()->updateAlias('hello', 'world', 20);

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/aliases/world', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('PUT', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/aliases/world', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"versionId":"20","description":null,"additionalVersionWeight":null}', (string) $this->request->getBody());
    }

    public function testUpdateAliasPassingAllParams()
    {
        $this->getClient()->updateAlias('hello', 'world', 10, 'hello-world', 40);
        $this->assertSame('{"versionId":"10","description":"hello-world","additionalVersionWeight":40}', (string) $this->request->getBody());
    }

    public function testDeleteAlias()
    {
        $this->getClient()->deleteAlias('hello', 'world');

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/services/hello/aliases/world', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('DELETE', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/services/hello/aliases/world', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }
}
