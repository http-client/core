<?php

declare(strict_types=1);

namespace WeForge\WeChat\MediaPlatform;

use WeForge\Concerns;
use WeForge\Http\Client;
use WeForge\WeChat\Exceptions\ResponseWithErrorException;

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
     * @var \DateInterval|int
     */
    public static $tokenExpireAt = 7000;

    /**
     * @var callable|null
     */
    protected static $getTokenUsing;

    /**
     * @var callable|null
     */
    protected static $freshTokenUsing;

    /**
     * Retrieve token from cache or fresh token.
     *
     * @return array
     */
    public function getToken(): array
    {
        [$appId] = $this->getOptions();

        return call_user_func(static::$getTokenUsing ?: function () {
            return $this->remember($this->cacheKey(), static::$tokenExpireAt, function () {
                return $this->requestToken();
            });
        }, $appId);
    }

    /**
     * Remove cache and fresh token.
     *
     * @return array
     */
    public function freshToken(): array
    {
        [$appId] = $this->getOptions();

        return call_user_func(static::$freshTokenUsing ?: function () {
            $this->getCache()->delete($this->cacheKey());

            return $this->getToken();
        }, $appId);
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

        $result = $this->castsResponseToArray($response);

        if (isset($result['errcode']) && ($result['errcode'] !== 0)) {
            throw ResponseWithErrorException::withResult($result);
        }

        return $result;
    }

    /**
     * @param callable $callback
     *
     * @return static
     */
    public static function getTokenUsing(callable $callback)
    {
        static::$getTokenUsing = $callback;

        return new static;
    }

    /**
     * @param callable $callback
     *
     * @return static
     */
    public static function freshTokenUsing(callable $callback)
    {
        static::$freshTokenUsing = $callback;

        return new static;
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
