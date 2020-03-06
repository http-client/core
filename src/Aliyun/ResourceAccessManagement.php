<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ResourceAccessManagement extends Client
{
    use ResourceAccessManagement\EncapsulatesRequests;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://ram.aliyuncs.com';
}
