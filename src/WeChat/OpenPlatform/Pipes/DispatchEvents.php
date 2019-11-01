<?php

declare(strict_types=1);

namespace WeForge\WeChat\OpenPlatform\Pipes;

use WeForge\WeChat\OpenPlatform\Laravel\Events;
use WeForge\WeForge;

class DispatchEvents
{
    /**
     * Dispatches events.
     *
     * @param array $payload
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
     * @param array $payload
     *
     * @return void
     */
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
