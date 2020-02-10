<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Aliyun\ObjectStorageService\AuthenticatesWithHeaders;
use HttpClient\Client;

class ObjectStorageServiceBucket extends Client
{
    use AuthenticatesWithHeaders;
    use ObjectStorageServiceBucket\GeneratesSignedUrls,
        ObjectStorageServiceBucket\ManagesBuckets,
        ObjectStorageServiceBucket\ManagesObjects;

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setBaseUri('https://'.$this->options['endpoint']);
    }
}
