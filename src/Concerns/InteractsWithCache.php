<?php

namespace WeForge\Concerns;

use Psr\SimpleCache\CacheInterface;

trait InteractsWithCache
{
    protected $cache;

    public function getCache()
    {
        return $this->cache ?: $this->cache = $this->createDefaultCache();
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    protected function createDefaultCache()
    {
        // todo
    }

    public function remember($key, $seconds, $callback)
    {
        return $callback();

        if ($this->getCache()->has($key)) {
            return $this->getCache()->get($key);
        }

        $this->getCache()->set($key, $callback(), $seconds);

        return $this->getCache()->get($key);
    }
}
