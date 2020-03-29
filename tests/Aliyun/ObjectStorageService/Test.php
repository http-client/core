<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\Tests\ObjectStorageService;

use HttpClient\Aliyun\ObjectStorageService\Application;
use HttpClient\Core\RequestException;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    protected $app;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new Application([
            'access_key_id' => getenv('ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => getenv('ALIYUN_ACCESS_KEY_SECRET'),
            'http' => [
                'base_uri' => 'https://oss-cn-shenzhen.aliyuncs.com',
            ],
        ]);
    }

    public function test_bucket_not_exists()
    {
        $app = $this->app->bucket('http-client-test-bucket-that-does-not-exists');

        try {
            $i = $app->info();
            $this->fail('fuck?');
        } catch (\Throwable $e) {
            $this->assertSame('https://http-client-test-bucket-that-does-not-exists.oss-cn-shenzhen.aliyuncs.com/?bucketInfo returned status code 404', $e->getMessage());
            $this->assertSame(404, $e->getCode());
            $this->assertInstanceOf(RequestException::class, $e);
            $this->assertSame(404, $e->response->getStatusCode());
            $this->assertSame('NoSuchBucket', $e->response['Code']);
            $this->assertSame('http-client-test-bucket-that-does-not-exists', $e->response['BucketName']);
        }
    }
}
