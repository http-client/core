<?php

declare(strict_types=1);

namespace WeForge\WeChat\MiniProgram\Pipes;

use WeForge\WeChat\MiniProgram\Laravel\Events\MessageReceived;
use WeForge\WeForge;

class DispatchEvents
{
    /**
     * Dispatches events.
     */
    public function __invoke(array $payload): array
    {
        if (WeForge::$runningInLaravel) {
            $this->dispatchLaravelEvents($payload);
        }

        return $payload;
    }

    /**
     * @return void
     */
    protected function dispatchLaravelEvents(array $payload)
    {
        MessageReceived::dispatch($payload);
    }
}
