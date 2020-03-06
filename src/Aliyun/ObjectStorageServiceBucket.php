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

    public function getBucketName()
    {
        preg_match('/http(s?):\/\/(\w+)./', $this->getBaseUri(), $matches);

        return $matches[2];
    }
}
