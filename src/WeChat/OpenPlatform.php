<?php

namespace WeForge\WeChat;

use WeForge\Http\Client;

class OpenPlatform extends Client
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';
}
