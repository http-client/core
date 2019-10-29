<?php

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

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    public function getCache(): CacheInterface
    {
        return $this->cache ?: $this->cache = $this->resolveCache();
    }

    /**
     * @param \Psr\SimpleCache\CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
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
     * @param int      $seconds
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function remember($key, $seconds, $callback)
    {
        if ($this->getCache()->has($key)) {
            return $this->getCache()->get($key);
        }

        $this->getCache()->set($key, $callback(), $seconds);

        return $this->getCache()->get($key);
    }
}
