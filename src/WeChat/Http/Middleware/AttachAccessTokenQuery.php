<?php

namespace WeForge\WeChat\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use WeForge\Http\Client;
use WeForge\WeChat\MediaPlatform\AccessTokenClient;

class AttachAccessTokenQuery
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
     * @param callable $next
     *
     * @return callable
     */
    public function __invoke(callable $next)
    {
        return function (RequestInterface $request, array $options) use ($next) {
            if ($this->shouldSkipMiddleware($request, $options)) {
                return $next($request, $options);
            }

            parse_str($request->getUri()->getQuery(), $query);
            $query = http_build_query(array_merge(['access_token' => $this->getTokenString()], $query));
            $request = $request->withUri($request->getUri()->withQuery($query));

            return $next($request, $options);
        };
    }

    /**
     * Skips the current middleware.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     *
     * @return bool
     */
    protected function shouldSkipMiddleware($request, $options)
    {
        return $request->getUri()->getPath() === '/cgi-bin/token';
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
}
