<?php

declare(strict_types=1);

namespace HttpClient\Events;

use HttpClient\Client;
use League\Event\AbstractEvent;

class ClientResolved extends AbstractEvent
{
    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
