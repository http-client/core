<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class CloudMonitor extends Client
{
    use CloudMonitor\EncapsulatesRequests;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://metrics.aliyuncs.com';
}
