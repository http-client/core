<?php

declare(strict_types=1);

namespace HttpClient\WeChat;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use HttpClient\Client;
use HttpClient\WeChat\Http\Middleware\CredentialInvalidDecider;
use HttpClient\WeChat\OpenPlatform\ComponentAccessTokenClient;
use HttpClient\WeChat\OpenPlatform\Http\Middleware\AddComponentAccessTokenToQuery;

class OpenPlatform extends Client
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
     * @return void
     */
    protected function apply(HandlerStack $handlerStack)
    {
        [$config] = $this->getOptions();

        $handlerStack->push(
            new AddComponentAccessTokenToQuery($this->baseUri, $config['app_id'], $config['secret'])
        );

        $handlerStack->push(Middleware::retry(
            new CredentialInvalidDecider(function () use ($config) {
                (new ComponentAccessTokenClient($config['app_id'], $config['secret']))->setBaseUri($this->baseUri)->freshToken();
            })
        ));
    }

    public function mediaPlatform($appId, $refreshToken = null)
    {
        [$config] = $this->getOptions();

        return $this->delegateAuthorizer($appId, $refreshToken, $config);
    }

    protected function delegateAuthorizer()
    {
        $client = new class(...func_get_args()) extends Client {
            protected $authorizerAppId;
            protected $authorizerRefreshToken;
            protected $componentConfig;

            public function __construct($authorizerAppId, $authorizerRefreshToken, $componentConfig)
            {
                $this->authorizerAppId = $authorizerAppId;
                $this->authorizerRefreshToken = $authorizerRefreshToken;
                $this->componentConfig = $componentConfig;
            }

            protected function apply(\GuzzleHttp\HandlerStack $handlerStack)
            {
                $handlerStack->push(
                    new \HttpClient\WeChat\OpenPlatform\Http\Middleware\Authorizer\AddAccessTokenToQuery(
                        new ComponentAccessTokenClient($this->componentConfig['app_id'], $this->componentConfig['secret']), $this->authorizerAppId, $this->authorizerRefreshToken,
                    )
                );
            }
        };

        // return $client->setHttpClient($this->getHttpClient())
        //         ->castsResponseUsing($this->castsResponseUsing);
        return $client->setBaseUri($this->baseUri)
                    ->setConfig($this->getConfig())
                    ->castsResponseUsing($this->castsResponseUsing);
    }
}
