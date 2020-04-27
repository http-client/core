<?php

namespace HttpClient\Middleware;

use Closure;
use Psr\Http\Message\RequestInterface;

class MergeQuery
{
    /**
     * The query callable.
     *
     * @var callable
     */
    protected $query;

    /**
     * @var callable|null
     */
    protected $ignoreWhen;

    /**
     * Create a new instance.
     *
     * @param callable|array $query
     *
     * @return void
     */
    public function __construct($query)
    {
        $this->query = is_callable($query) ? $query : function () use ($query) {
            return $query;
        };
    }

    /**
     * Determine whether should ignore the current middleware.
     *
     * @return $this
     */
    public function ignoreWhen(Closure $callback)
    {
        $this->ignoreWhen = $callback;

        return $this;
    }

    /**
     * @return callable
     */
    public function __invoke(callable $next)
    {
        return function (RequestInterface $request, array $options) use ($next) {
            if ($this->ignoreWhen instanceof Closure && $this->ignoreWhen->__invoke($request, $options)) {
                return $next($request, $options);
            }

            parse_str($request->getUri()->getQuery(), $query);
            $query = http_build_query(array_merge(call_user_func($this->query), $query));

            $request = $request->withUri($request->getUri()->withQuery($query));

            return $next($request, $options);
        };
    }
}
