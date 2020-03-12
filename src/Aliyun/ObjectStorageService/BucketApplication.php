<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

use HttpClient\Aliyun\Signature\AuthorizationSignature;
use HttpClient\Core\Application as BaseApplication;

class BucketApplication extends BaseApplication
{
    /**
     * @return void
     */
    protected function boot()
    {
        $this['client'] = function ($pimple) {
            return new \HttpClient\Aliyun\ObjectStorageService\Client($pimple);
        };

        $this['object'] = function ($pimple) {
            return new BucketObject($pimple);
        };
    }

    public function info()
    {
        return $this['client']->request('GET', '/?bucketInfo');
    }

    public function create()
    {
        return $this['client']->request('PUT', '/');
    }

    public function delete()
    {
        return $this['client']->request('DELETE', '/');
    }

    protected function signForQueryString($method, $date, $resource)
    {
        return AuthorizationSignature::sign($method, '', '', $date, [], $resource, $this['options']['access_key_secret']);
    }

    public function getSignedUrlForGettingObject($filename)
    {
        $signature = $this->signForQueryString(
            'GET', $date = time() + 300,
            sprintf('/%s/%s', $this['options']['bucket'], $filename)
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
