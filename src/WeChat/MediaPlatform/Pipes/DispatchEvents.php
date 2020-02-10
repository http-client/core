<?php

declare(strict_types=1);

namespace HttpClient\WeChat\MediaPlatform\Pipes;

use HttpClient\WeChat\MediaPlatform\Laravel\Events\MessageReceived;

class DispatchEvents
{
    /**
     * Dispatches events.
     *
     * @return array
     */
    public function __invoke(array $payload)
    {
        // if (WeForge::$runningInLaravel) {
        //     $this->dispatchLaravelEvents($payload);
        // }

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
