<?php

declare(strict_types=1);

namespace HttpClient\WeChat\MediaPlatform\Http\Middleware;

use HttpClient\Http\Middleware\MergeQuery;
use HttpClient\WeChat\MediaPlatform\AccessTokenClient;

class AddAccessTokenToQuery extends MergeQuery
{
    /**
     * Base URI of the http client.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * AppId.
     *
     * @var string
     */
    protected $appId;

    /**
     * App Secret.
     *
     * @var string
     */
    protected $secret;

    /**
     * @param string $baseUri
     * @param string $appId
     * @param string $secret
     */
    public function __construct($baseUri, $appId, $secret)
    {
        $this->baseUri = $baseUri;
        $this->appId = $appId;
        $this->secret = $secret;
    }

    /**
     * Merges query to the request.
     */
    protected function getQuery(): array
    {
        return ['access_token' => $this->getTokenString()];
    }

    /**
     * @return string
     */
    protected function getTokenString()
    {
        return (new AccessTokenClient($this->appId, $this->secret))
                    ->setBaseUri($this->baseUri)
                    ->getToken()['access_token'];
    }

    /**
     * Skips the current middleware.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     */
    protected function shouldSkipMiddleware($request, $options): bool
    {
        return $request->getUri()->getPath() === '/cgi-bin/token';
    }
}
