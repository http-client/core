<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform;

use HttpClient\Client;
use HttpClient\Concerns;
use HttpClient\Contracts\AccessToken;
use HttpClient\WeChat\Exceptions\ResponseWithErrorException;

class ComponentAccessTokenClient extends Client implements AccessToken
{
    use Concerns\CastsResponse, Concerns\InteractsWithCache;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';

    protected $componentAccessTokenCache;
    protected $componentVerifyTicketCache;

    /**
     * The date when access token expire.
     *
     * @var \DateInterval|int
     */
    public static $tokenExpireAt = 7000;

    /**
     * @var callable|null
     */
    protected static $getTokenUsing;

    /**
     * Retrieve token from cache or fresh token.
     */
    public function getToken()
    {
        [$appId] = $this->getOptions();

        return call_user_func(static::$getTokenUsing ?: function () {
            return $this->getComponentAccessTokenCache()->remember(static::$tokenExpireAt, function () {
                return $this->requestToken()['component_access_token'];
            });
        }, $appId);
    }

    public function getAppId()
    {
        [$appId] = $this->getOptions();

        return $appId;
    }

    /**
     * Remove cache and fresh token.
     */
    public function freshToken(): array
    {
        $this->getComponentAccessTokenCache()->delete();

        return $this->getToken();
    }

    /**
     * Request access-token from api.
     */
    public function requestToken(): array
    {
        $response = $this->withoutResponseCasting(function () {
            [$appId, $appSecret] = $this->getOptions();

            return $this->postJson('cgi-bin/component/api_component_token', [
                'component_appid' => $appId, 'component_appsecret' => $appSecret, 'component_verify_ticket' => $this->getComponentVerifyTicketCache()->get(),
            ]);
        });

        $result = $this->castsResponseToArray($response);

        if (isset($result['errcode']) && ($result['errcode'] !== 0)) {
            throw ResponseWithErrorException::withResult($result);
        }

        return $result;
    }

    /**
     * @return \WeForge\WeChat\OpenPlatform\ComponentVerifyTicketCache
     */
    protected function getComponentVerifyTicketCache()
    {
        if ($this->componentVerifyTicketCache) {
            return $this->componentVerifyTicketCache;
        }

        [$appId] = $this->getOptions();

        return $this->componentVerifyTicketCache = new ComponentVerifyTicketCache($appId);
    }

    /**
     * @return \WeForge\WeChat\OpenPlatform\ComponentAccessTokenCache
     */
    protected function getComponentAccessTokenCache()
    {
        if ($this->componentAccessTokenCache) {
            return $this->componentAccessTokenCache;
        }

        [$appId] = $this->getOptions();

        return $this->componentAccessTokenCache = new ComponentAccessTokenCache($appId);
    }
}