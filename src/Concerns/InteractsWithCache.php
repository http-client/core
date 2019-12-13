<?php

declare(strict_types=1);

namespace WeForge\Concerns;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use WeForge\WeForge;

trait InteractsWithCache
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    public function getCache(): CacheInterface
    {
        return $this->cache ?: $this->cache = $this->resolveCache();
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    protected function resolveCache(): CacheInterface
    {
        if (WeForge::$resolveCacheUsing) {
            return call_user_func(WeForge::$resolveCacheUsing);
        }

        return new Psr16Cache(
            new FilesystemAdapter
        );
    }

    /**
     * @param string   $key
     * @param int      $ttl
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function remember($key, $ttl, $callback)
    {
        if ($this->getCache()->has($key)) {
            return $this->getCache()->get($key);
        }

        $this->getCache()->set($key, $callback(), $ttl);

        return $this->getCache()->get($key);
    }
}
