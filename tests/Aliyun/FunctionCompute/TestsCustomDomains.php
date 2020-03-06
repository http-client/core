<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\FunctionCompute;

use HttpClient\Aliyun\Signature\AuthorizationSignature;

trait TestsCustomDomains
{
    public function testGetCustomDomain()
    {
        $this->getClient()->getCustomDomain('http-client.com');

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/custom-domains/http-client.com', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/custom-domains/http-client.com', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testGetCustomDomains()
    {
        $this->getClient()->getCustomDomains();

        $this->assertSame('GET', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/custom-domains', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('GET', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/custom-domains', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }

    public function testCreateCustomDomain()
    {
        $this->getClient()->createCustomDomain('http-client.com', 'HTTP');

        $this->assertSame('POST', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/custom-domains', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('POST', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/custom-domains', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"DomainName":"http-client.com","Protocol":"HTTP"}', (string) $this->request->getBody());
    }

    public function testCreateCustomDomainPassingAllParams()
    {
        $this->getClient()->createCustomDomain('http-client.com', 'HTTP', ['Routes' => [
            ['path' => '/foo', 'serviceName' => 'test', 'functionName' => 'foo'],
        ]], ['certName' => 'test', 'privateKey' => 'xxxxxx', 'certificate' => 'xxxxxx']);

        $this->assertSame('{"DomainName":"http-client.com","Protocol":"HTTP","RouteConfig":{"Routes":[{"path":"\/foo","serviceName":"test","functionName":"foo"}]},"CertConfig":{"certName":"test","privateKey":"xxxxxx","certificate":"xxxxxx"}}', (string) $this->request->getBody());
    }

    public function testUpdateCustomDomain()
    {
        $this->getClient()->updateCustomDomain('http-client.com', 'HTTP');

        $this->assertSame('PUT', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/custom-domains/http-client.com', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('PUT', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/custom-domains/http-client.com', 'test', 'sha256'), $headers['Authorization'][0]
        );

        $this->assertSame('{"Protocol":"HTTP"}', (string) $this->request->getBody());
    }

    public function testUpdateCustomDomainPassingAllParams()
    {
        $this->getClient()->updateCustomDomain('http-client.com', 'HTTP', ['Routes' => [
            ['path' => '/foo', 'serviceName' => 'test', 'functionName' => 'foo'],
        ]], ['certName' => 'test', 'privateKey' => 'xxxxxx', 'certificate' => 'xxxxxx']);

        $this->assertSame('{"Protocol":"HTTP","RouteConfig":{"Routes":[{"path":"\/foo","serviceName":"test","functionName":"foo"}]},"CertConfig":{"certName":"test","privateKey":"xxxxxx","certificate":"xxxxxx"}}', (string) $this->request->getBody());
    }

    public function testDeleteCustomDomain()
    {
        $this->getClient()->deleteCustomDomain('http-client.com');

        $this->assertSame('DELETE', $this->request->getMethod());
        $this->assertSame('https', $this->request->getUri()->getScheme());
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $this->request->getUri()->getHost());
        $this->assertSame('/2016-08-15/custom-domains/http-client.com', $this->request->getUri()->getPath());

        $headers = $this->request->getHeaders();
        $this->assertSame('123456.cn-shenzhen.fc.aliyuncs.com', $headers['Host'][0]);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
        $this->assertSame('0', $headers['Content-Length'][0]);
        $this->assertSame(
            'FC test-id:'.AuthorizationSignature::sign('DELETE', '', 'application/json', $headers['Date'][0], [], '/2016-08-15/custom-domains/http-client.com', 'test', 'sha256'), $headers['Authorization'][0]
        );
    }
}
