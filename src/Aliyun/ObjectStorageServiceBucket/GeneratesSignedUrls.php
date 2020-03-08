<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

use HttpClient\Aliyun\SignatureCalculator;

trait GeneratesSignedUrls
{
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

    public function getSignedUrlForPuttingObject(string $filename, string $secToken)
    {
        $signature = $this->signForQueryString(
            'PUT', $date = time() + 300,
            sprintf('/%s/%s?security-token=%s', $this->getBucketName(), $filename, $secToken)
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
