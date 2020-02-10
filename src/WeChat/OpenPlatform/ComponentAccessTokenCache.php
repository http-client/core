<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform;

use Closure;
use DateInterval;
use HttpClient\Concerns\InteractsWithCache;

class ComponentAccessTokenCache
{
    use InteractsWithCache { remember as rememberCache; }

    /**
     * The cache prefix.
     *
     * @var string
     */
    protected $prefix = 'http-client.wechat.open_platform.component-access-token.x';

    /**
     * @var string
     */
    protected $appId;

    /**
     * @param string $appId
     */
    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->getCache()->get($this->prefix.$this->appId);
    }

    /**
     * @param mixed                  $value
     * @param int|\DateInterval|null $ttl
     *
     * @return void
     */
    public function set($value, $ttl = null)
    {
        $this->getCache()->set(
            $this->prefix.$this->appId, $value, is_string($ttl) ? DateInterval::createFromDateString($ttl) : $ttl
        );
    }

    public function remember($ttl, Closure $callback)
    {
        return $this->rememberCache($this->prefix.$this->appId, $ttl, $callback);
    }

    public function delete()
    {
        $this->getCache()->delete($this->prefix.$this->appId);
    }
}
