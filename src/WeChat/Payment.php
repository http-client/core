<?php

declare(strict_types=1);

namespace HttpClient\WeChat;

use WeForge\Http\Client;

class Payment extends Client
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.mch.weixin.qq.com/v3';
}
