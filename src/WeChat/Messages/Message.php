<?php

declare(strict_types=1);

namespace HttpClient\WeChat\Messages;

abstract class Message
{
    /**
     * @var string
     */
    protected $type;

    public function type(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return [];
    }
}
