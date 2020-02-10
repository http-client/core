<?php

declare(strict_types=1);

namespace HttpClient\Http\Middleware;

use Psr\Http\Message\RequestInterface;

class MergeQuery
{
    /**
     * @return callable
     */
    public function __invoke(callable $next)
    {
        return function (RequestInterface $request, array $options) use ($next) {
            if ($this->shouldSkipMiddleware($request, $options)) {
                return $next($request, $options);
            }

            parse_str($request->getUri()->getQuery(), $query);
            $query = http_build_query(array_merge($this->getQuery(), $query));
            $request = $request->withUri($request->getUri()->withQuery($query));

            return $next($request, $options);
        };
    }

    /**
     * Skips the current middleware.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     */
    protected function shouldSkipMiddleware($request, $options): bool
    {
        return false;
    }

    /**
     * Merges query to the request.
     */
    protected function getQuery(): array
    {
        return [];
    }
}
