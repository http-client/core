<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

trait ManagesBuckets
{
    /**
     * Get info of the given bucket.
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->encapsulateRequest('GET', '/?bucketInfo');
    }

    /**
     * Create a bucket.
     *
     * @return mixed
     */
    public function createBucket()
    {
        return $this->encapsulateRequest('PUT', '/');
    }

    /**
     * Delete a given bucket.
     *
     * @return mixed
     */
    public function deleteBucket()
    {
        return $this->encapsulateRequest('DELETE', '/');
    }
}
