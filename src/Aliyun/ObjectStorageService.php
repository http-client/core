<?php

declare(strict_types=1);

namespace WeClient\Aliyun;

use GuzzleHttp\HandlerStack;
use WeClient\Client;

class ObjectStorageService extends Client
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://oss-cn-shenzhen.aliyuncs.com';

    /**
     * Apply to handler stack.
     *
     * @return void
     */
    protected function apply(HandlerStack $stack)
    {
        // $stack->push(new SignatureCalculationsForAuthorizationHeader);
    }
}
