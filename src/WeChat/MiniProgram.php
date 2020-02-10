<?php

declare(strict_types=1);

namespace HttpClient\WeChat;

use WeForge\Http\Client;

class MiniProgram extends Client
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';
}
