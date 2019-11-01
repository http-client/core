<?php

declare(strict_types=1);

namespace WeForge\WeChat;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use WeForge\Http\Client;
use WeForge\WeChat\Http\Middleware\CredentialInvalidDecider;
use WeForge\WeChat\MediaPlatform\AccessTokenClient;
use WeForge\WeChat\MediaPlatform\Http\Middleware\AddAccessTokenToQuery;

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
        parent::apply($handlerStack);

        [$config] = $this->getOptions();

        $handlerStack->push(
            new AddAccessTokenToQuery($this->baseUri, $config['app_id'], $config['secret'])
        );

        $handlerStack->push(Middleware::retry(
            new CredentialInvalidDecider(function () use ($config) {
                (new AccessTokenClient($config['app_id'], $config['secret']))->setBaseUri($this->baseUri)->freshToken();
            })
        ));
    }
}
