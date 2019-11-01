<?php

declare(strict_types=1);

namespace WeForge\WeChat\Messages;

abstract class Message
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
