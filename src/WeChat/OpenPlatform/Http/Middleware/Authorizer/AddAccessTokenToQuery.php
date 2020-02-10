<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform\Http\Middleware\Authorizer;

use HttpClient\Http\Middleware\MergeQuery;
use HttpClient\WeChat\OpenPlatform\AuthorizerAccessTokenClient;
use HttpClient\WeChat\OpenPlatform\ComponentAccessTokenClient;

class AddAccessTokenToQuery extends MergeQuery
{
    protected $baseClient;
    protected $appId;
    protected $refreshToken;

    public function __construct(ComponentAccessTokenClient $baseClient, $appId, $refreshToken)
    {
        $this->baseClient = $baseClient;
        $this->appId = $appId;
        $this->refreshToken = $refreshToken;
    }

    /**
     * Merges query to the request.
     */
    protected function getQuery(): array
    {
        return [
            'access_token' => (new AuthorizerAccessTokenClient($this->baseClient, $this->appId, $this->refreshToken))->getToken(),
        ];
    }
}
