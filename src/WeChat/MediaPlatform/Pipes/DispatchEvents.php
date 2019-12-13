<?php

declare(strict_types=1);

namespace WeForge\WeChat\MediaPlatform\Pipes;

use WeForge\WeChat\MediaPlatform\Laravel\Events\MessageReceived;
use WeForge\WeForge;

class DispatchEvents
{
    /**
     * Dispatches events.
     *
     * @return array
     */
    public function __invoke(array $payload)
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
