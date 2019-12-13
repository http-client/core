<?php

declare(strict_types=1);

namespace WeForge\WeChat\OpenPlatform\Http\Middleware;

use WeForge\Http\Middleware\MergeQuery;
use WeForge\WeChat\OpenPlatform\ComponentAccessTokenClient;

class AddComponentAccessTokenToQuery extends MergeQuery
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
        return ['component_access_token' => $this->getTokenString()];
    }

    /**
     * @return string
     */
    protected function getTokenString()
    {
        return (new ComponentAccessTokenClient($this->appId, $this->secret))
                    ->setBaseUri($this->baseUri)
                    ->getToken()['component_access_token'];
    }
}
