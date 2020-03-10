<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CertificateAuthorityService;

use HttpClient\Core\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://cas.aliyuncs.com';

    /**
     * @return void
     */
    protected function boot()
    {
        //
    }
}
