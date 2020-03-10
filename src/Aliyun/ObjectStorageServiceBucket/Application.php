<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    protected $providers = [
        ServiceProvider::class,
    ];

    public function info()
    {
        return $this['client']->request('GET', '/?bucketInfo');
    }

    public function create()
    {
        return $this->request('PUT', '/');
    }

    public function delete()
    {
        return $this->request('DELETE', '/');
    }

    protected function signForQueryString($method, $date, $resource)
    {
        return AuthorizationSignature::sign($method, '', '', $date, [], $resource, $this['options']['access_key_secret']);
    }

    public function getSignedUrlForGettingObject($filename)
    {
        $signature = $this->signForQueryString(
            'GET', $date = time() + 300,
            sprintf('/%s/%s', $this->getBucketName(), $filename)
        );

        $query = http_build_query([
            'OSSAccessKeyId' => $this->options['access_key_id'],
            'Expires' => $date,
            'Signature' => $signature,
            // 'security-token' => $secToken,
        ]);

        return sprintf('%s/%s?%s', $this->getBaseUri(), $filename, $query);
    }

    public function getSignedUrlForPuttingObject(string $filename, string $secToken = null)
    {
        $signature = $this->signForQueryString(
            'PUT', $date = time() + 300,
            sprintf('/%s/%s?security-token=%s', $this['options']['bucket'], $filename, $secToken)
        );

        // $calculator = new SignatureCalculator('sha1', $this->options['access_key_secret']);

        // $signature = $calculator->calculate(
        //     'PUT', $md5 = '', $contentType = '', $date = time() + 300, [],
        //     sprintf('/%s/%s?security-token=%s', $this->getBucketName(), $filename, $secToken),
        // );

        $query = http_build_query([
            'OSSAccessKeyId' => $this->options['access_key_id'],
            'Expires' => $date,
            'Signature' => $signature,
            'security-token' => $secToken,
        ]);

        return sprintf('%s/%s?%s', $this->getBaseUri(), $filename, $query);
    }
}
