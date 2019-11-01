<?php

declare(strict_types=1);

namespace WeForge\WeChat\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use WeForge\Concerns\CastsResponse;
use WeForge\Support\Logger;

class CredentialInvalidDecider
{
    use CastsResponse;

    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @var array
     */
    protected $retryCodes = [40001, 40014, 42001];

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
        return is_null($exception) &&
                $this->maxRetries() >= $retries &&
                $this->retryable($request, $response);
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
     *
     * @return bool
     */
    protected function retryable(RequestInterface $request, ResponseInterface $response = null): bool
    {
        $array = $this->castsResponseToArray($response);

        if (in_array($array['errcode'] ?? null, $this->retryCodes)) {
            // Logger::debug('Refreshing an access-token.', $array);

            call_user_func($this->callback);

            return true;
        }

        return false;
    }
}
