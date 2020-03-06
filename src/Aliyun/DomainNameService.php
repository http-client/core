<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class DomainNameService extends Client
{
    use DomainNameService\EncapsulatesRequests;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://alidns.aliyuncs.com';
}
