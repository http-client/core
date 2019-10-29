<?php

namespace WeForge\WeChat\MediaPlatform;

use WeForge\Concerns;
use WeForge\Http\Client;

class AccessTokenClient extends Client
{
    use Concerns\CastsResponse, Concerns\InteractsWithCache;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';

    /**
     * The date when access token expire.
     *
     * @var int
     */
    public static $tokenExpireAt = 7000;

    /**
     * Retrieve token from cache or fresh token.
     *
     * @return array
     */
    public function getToken(): array
    {
        return $this->remember($this->cacheKey(), static::$tokenExpireAt, function () {
            return $this->requestToken();
        });
    }

    /**
     * Remove cache and fresh token.
     *
     * @return array
     */
    public function freshToken(): array
    {
        $this->getCache()->delete($this->cacheKey());

        return $this->getToken();
    }

    /**
     * Request access-token from api.
     *
     * @return array
     */
    public function requestToken(): array
    {
        $response = $this->withoutResponseCasting(function () {
            [$appId, $appSecret] = $this->getOptions();

            return $this->get('cgi-bin/token', [
                'grant_type' => 'client_credential', 'appid' => $appId, 'secret' => $appSecret,
            ]);
        });

        return $this->castsResponseToArray($response);
    }

    /**
     * @return string
     */
    protected function cacheKey(): string
    {
        [$appId] = $this->getOptions();

        return 'weforge.wechat.media-platform.access-token.'.md5($appId);
    }
}
