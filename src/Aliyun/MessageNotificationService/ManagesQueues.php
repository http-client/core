<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

trait ManagesQueues
{
    public function getQueues()
    {
        return $this->encapsulatesRequest('GET', '/queues');
    }

    public function createQueue($name, array $attribuets = [])
    {
        return $this->encapsulatesRequest('PUT', '/queues/'.$name, [
            'body' => XML::make('Queue', $attribuets),
        ]);
    }

    public function deleteQueue($name)
    {
        return $this->encapsulatesRequest('DELETE', '/queues/'.$name);
    }

    public function getQueue($name)
    {
        return $this->encapsulatesRequest('GET', "/queues/${name}");
    }
}
