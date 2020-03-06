<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class CertificateAuthorityService extends Client
{
    use CertificateAuthorityService\EncapsulatesRequests;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://cas.aliyuncs.com';
}
