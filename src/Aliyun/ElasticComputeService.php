<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ElasticComputeService extends Client
{
    use ElasticComputeService\EncapsulatesRequests;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://ecs.aliyuncs.com';
}
