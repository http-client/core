<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class MessageNotificationService extends Client
{
    use MessageNotificationService\EncapsulatesRequests,
        MessageNotificationService\ManagesQueues,
        MessageNotificationService\ManagesQueueMessages;

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setBaseUri('https://'.$this->options['endpoint']);
    }
}
