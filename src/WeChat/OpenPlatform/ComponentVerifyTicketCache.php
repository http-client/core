<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform;

use DateInterval;
use HttpClient\Concerns\InteractsWithCache;

class ComponentVerifyTicketCache
{
    use InteractsWithCache;

    /**
     * The cache prefix.
     *
     * @var string
     */
    protected $prefix = 'weforge.wechat.open_platform.verify_ticket.';

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

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->getCache()->get($this->prefix.$this->appId);
    }
}
