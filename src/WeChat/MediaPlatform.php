<?php

declare(strict_types=1);

namespace HttpClient\WeChat;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use HttpClient\Client;
use HttpClient\WeChat\Http\Middleware\CredentialInvalidDecider;
use HttpClient\WeChat\MediaPlatform\AccessTokenClient;
use HttpClient\WeChat\MediaPlatform\Http\Middleware\AddAccessTokenToQuery;

/**
 * @name 公众号
 */
class MediaPlatform extends Client
{
    use MediaPlatform\ManagesUsers,
        MediaPlatform\ManagesTags;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';

    /**
     * Apply to handler stack.
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
