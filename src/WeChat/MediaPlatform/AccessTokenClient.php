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
     * Retrieve token from cache or fresh token.
     *
     * @return array
     */
    public function getToken()
    {
        [$appId, $appSecret] = $this->getOptions();

        return $this->remember('weforge.wechat.media-platform.access-token.'.$appId, 7000, function () use ($appId, $appSecret) {
            return $this->freshToken($appId, $appSecret);
        });
    }

    /**
     * Fresh access-token from api.
     *
     * @param string $appId
     * @param string $appSecret
     *
     * @return array
     */
    public function freshToken($appId, $appSecret)
    {
        $response = $this->withoutResponseCasting(function () use ($appId, $appSecret) {
            return $this->get('cgi-bin/token', [
                'grant_type' => 'client_credential', 'appid' => $appId, 'secret' => $appSecret,
            ]);
        });

        return $this->castsResponseToArray($response);
    }
}
