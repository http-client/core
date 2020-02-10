<?php

declare(strict_types=1);

namespace HttpClient\WeChat\OpenPlatform\Pipes;

use HttpClient\WeChat\OpenPlatform\Laravel\Events;

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

    protected function dispatchLaravelEvents(array $payload): void
    {
        Events\EventReceived::dispatch($payload);

        $events = [
            'component_verify_ticket' => Events\VerifyTicketReceived::class,
        ];

        if ($event = $events[$payload['InfoType']] ?? null) {
            $event::dispatch($payload);
        }
    }
}
