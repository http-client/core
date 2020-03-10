<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

class Queue extends Client
{
    public function list()
    {
        return $this->request('GET', '/queues');
    }

    public function create($name, array $attribuets = [])
    {
        return $this->request('PUT', '/queues/'.$name, [
            'body' => XML::make('Queue', $attribuets),
        ]);
    }

    public function delete($name)
    {
        return $this->request('DELETE', '/queues/'.$name);
    }

    public function get($name)
    {
        return $this->request('GET', "/queues/${name}");
    }
}
