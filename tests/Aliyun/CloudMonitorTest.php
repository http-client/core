<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun;

use HttpClient\Aliyun\CloudMonitor;
use HttpClient\Aliyun\Signature\RpcSignature;
use HttpClient\Tests\TestCase;

class CloudMonitorTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->mockClient(new CloudMonitor([
            'access_key_id' => 'test-access-key-id',
            'access_key_secret' => 'test-access-key-secret',
            'endpoint' => 'metrics.aliyuncs.com',
        ]));
    }

    protected function assertQueries($query)
    {
        $this->assertCount(9, $query);
        $this->assertSame('JSON', $query['Format']);
        $this->assertSame('2019-01-01', $query['Version']);
        $this->assertSame('test-access-key-id', $query['AccessKeyId']);
        $this->assertSame('HMAC-SHA1', $query['SignatureMethod']);
        $this->assertSame('1.0', $query['SignatureVersion']);
        $this->assertSame(16, strlen($query['SignatureNonce']));
        // $this->assertRegExp('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z/', $query['Timestamp']);
    }

    protected function assertSignature($query)
    {
        $signature = $query['Signature'];
        unset($query['Signature']);
        $this->assertSame($signature, (new RpcSignature('POST'))->sign($query, 'test-access-key-secret'));
    }

    public function testGetProjectMetas()
    {
        $response = $this->client->getProjectMetas();

        $this->assertSame('POST', $response->method);
        $this->assertSame('', $response->uri);
        $this->assertQueries($query = $response->options['query']);
        $this->assertSame('DescribeProjectMeta', $query['Action']);
        $this->assertSignature($query);
    }
}
