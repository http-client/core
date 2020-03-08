<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

trait ResolvesCache
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    /**
     * @var callable
     */
    protected $resolveCacheUsing;

    /**
     * @return $this
     */
    public function resolveCacheUsing(callable $callback)
    {
        $this->resolveCacheUsing = $callback;

        return $this;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    protected function resolveCache()
    {
        return $this->cache
                ?: $this->cache = call_user_func($this->resolveCacheUsing);
    }
}
