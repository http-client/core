<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform;

use DateInterval;
use HttpClient\Client;
use HttpClient\Concerns\CastsResponse;
use HttpClient\Concerns\InteractsWithCache;
use HttpClient\Contracts\AccessToken;

class AuthorizerAccessTokenClient extends Client implements AccessToken
{
    use CastsResponse, InteractsWithCache;

    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com';

    protected $baseClient;
    protected $appId;
    protected $refreshToken;

    public function __construct(ComponentAccessTokenClient $baseClient, $appId, $refreshToken)
    {
        $this->baseClient = $baseClient;
        $this->appId = $appId;
        $this->refreshToken = $refreshToken;
    }

    public function getToken()
    {
        $result = $this->remember(md5($this->baseClient->getAppId().$this->appId), DateInterval::createFromDateString('7000 seconds'), function () {
            return $this->requestToken();
        });

        return $result['authorizer_access_token'];
    }

    public function requestToken()
    {
        return $this->castsResponseToArray(
            $this->withoutResponseCasting(function () {
                return $this->request('POST', 'cgi-bin/component/api_authorizer_token', [
                    'query' => ['component_access_token' => $this->baseClient->getToken()],
                    'json' => [
                        'component_appid' => $this->baseClient->getAppId(),
                        'authorizer_appid' => $this->appId,
                        'authorizer_refresh_token' => $this->refreshToken,
                    ],
                ]);
            })
        );
    }
}
