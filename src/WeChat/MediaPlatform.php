<?php

namespace WeForge\WeChat;

use GuzzleHttp\HandlerStack;
use WeForge\Http\Client;
use WeForge\WeChat\Http\Middleware\AttachAccessTokenQuery;

class MediaPlatform extends Client
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';

    /**
     * Apply to handler stack.
     *
     * @param \GuzzleHttp\HandlerStack $handlerStack
     *
     * @return void
     */
    protected function apply(HandlerStack $handlerStack)
    {
        [$config] = $this->getOptions();

        $handlerStack->push(
            new AttachAccessTokenQuery($this->baseUri, $config['app_id'], $config['secret'])
        );
    }
}
