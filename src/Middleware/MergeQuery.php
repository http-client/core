<?php



namespace HttpClient\Middleware;

use Psr\Http\Message\RequestInterface;

class MergeQuery
{
    protected $query;
    protected $condition;

    public function __construct($query, $condition = null)
    {
        $this->query = $query;
        $this->condition = $condition;
    }

    /**
     * @return callable
     */
    public function __invoke(callable $next)
    {
        return function (RequestInterface $request, array $options) use ($next) {
            if ($this->shouldSkip($request, $options)) {
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
    protected function shouldSkip($request, $options): bool
    {
        if ($this->condition) {
            return call_user_func_array($this->condition, [$request, $options]);
        }

        return false;
    }

    /**
     * Merges query to the request.
     */
    protected function getQuery(): array
    {
        if (is_array($this->query)) {
            return $this->query;
        }

        return call_user_func($this->query);
    }
}
