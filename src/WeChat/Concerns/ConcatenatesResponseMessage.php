<?php

declare(strict_types=1);

namespace WeForge\WeChat\Concerns;

trait ConcatenatesResponseMessage
{
    /**
     * @param string|int|\WeForge\WeChat\Messages\Message $message
     */
    protected function concatReplyMessage(string $to, string $from, $message): array
    {
        if (is_scalar($message)) {
            $message = new Text($message);
        }

        return array_merge([
            'ToUserName' => $to,
            'FromUserName' => $from,
            'CreateTime' => time(),
            'MsgType' => $message->type(),
        ], $message->toArray());
    }
}
