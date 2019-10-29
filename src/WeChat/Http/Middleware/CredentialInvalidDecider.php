<?php

declare(strict_types=1);

namespace WeForge\WeChat\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use WeForge\Concerns\CastsResponse;
use WeForge\WeChat\MediaPlatform\AccessTokenClient;

class CredentialInvalidDecider
{
    use CastsResponse;

    /**
     * @var array
     */
    protected $retryCodes = [40001, 40014, 42001];

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
    public function __construct(string $baseUri, string $appId, string $secret)
    {
        $this->baseUri = $baseUri;
        $this->appId = $appId;
        $this->secret = $secret;
    }

    /**
     * @param int                                      $retries
     * @param \Psr\Http\Message\RequestInterface       $request
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @param Exception                                $exception
     *
     * @return bool
     */
    public function __invoke(int $retries, RequestInterface $request, ResponseInterface $response = null, $exception = null): bool
    {
        return $this->maxRetries() >= $retries && $this->retryable($request, $response, $exception);
    }

    /**
     * The max retries count.
     *
     * @return int
     */
    protected function maxRetries(): int
    {
        return 3;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface       $request
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @param Exception                                $exception
     *
     * @return bool
     */
    protected function retryable(RequestInterface $request, ResponseInterface $response = null, $exception = null): bool
    {
        if (in_array($this->castsResponseToArray($response)['errcode'] ?? null, $this->retryCodes)) {
            (new AccessTokenClient($this->appId, $this->secret))->setBaseUri($this->baseUri)->freshToken();

            return true;
        }

        return false;
    }
}
