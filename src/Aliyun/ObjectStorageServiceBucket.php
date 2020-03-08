<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ObjectStorageServiceBucket extends Client
{
    use ObjectStorageService\EncapsulatesRequests,
        ObjectStorageServiceBucket\GeneratesSignedUrls,
        ObjectStorageServiceBucket\ManagesBuckets,
        ObjectStorageServiceBucket\ManagesObjects;

    /**
     * Get the name of the bucket.
     *
     * @return string
     */
    public function getBucketName()
    {
        preg_match('/^https?:\/\/(.*?)\./', $this->getBaseUri(), $matches);

        return $matches[1];
    }
}
