<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class VirtualPrivateCloud extends Client
{
    use VirtualPrivateCloud\EncapsulatesRequests,
        VirtualPrivateCloud\ManagesVpcs;

    protected $baseUri = 'https://vpc.aliyuncs.com';
}
