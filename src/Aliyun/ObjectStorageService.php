<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ObjectStorageService extends Client
{
    use ObjectStorageService\AuthenticatesWithHeaders,
        ObjectStorageService\ManagesServices;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://oss-cn-shenzhen.aliyuncs.com';
}
