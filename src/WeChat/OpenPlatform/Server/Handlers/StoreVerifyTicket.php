<?php

declare(strict_types=1);

namespace WeForge\WeChat\OpenPlatform\Server\Handlers;

use WeForge\WeChat\OpenPlatform\ComponentVerifyTicketCache;

class StoreVerifyTicket
{
    public function __invoke(array $payload): void
    {
        if ($payload['InfoType'] !== 'component_verify_ticket') {
            return;
        }

        (new ComponentVerifyTicketCache($payload['AppId']))
            ->set($payload['ComponentVerifyTicket'], '1 hour');
    }
}
