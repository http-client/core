<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

trait ManagesBuckets
{
    public function getBucketInfo()
    {
        $resource = '/?bucketInfo';

        $headers = $this->authenticateWithHeaders('GET', '/'.$this->options['bucket_name'].$resource);

        return $this->request('GET', $resource, [
            'headers' => $headers,
        ]);
    }

    public function putBucket()
    {
        $headers = $this->authenticateWithHeaders('PUT', "/{$this->options['bucket_name']}/");

        return $this->request('PUT', '/', [
            'headers' => $headers,
        ]);
    }
}
