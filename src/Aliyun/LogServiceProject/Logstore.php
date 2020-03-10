<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogServiceProject;

use HttpClient\Aliyun\LogService\Client;

class Logstore extends Client
{
    public function getLogstore($name)
    {
        return $this->request('GET', "/logstores/{$name}");
    }

    public function createLogstore($name, $ttl, $shardCount)
    {
        return $this->request('POST', '/logstores', [
            'logstoreName' => $name,
            'ttl' => $ttl,
            'shardCount' => $shardCount,
        ]);
    }

    public function getLogstores()
    {
        $headers = $this->authenticateWithHeaders('GET', $resource = '/logstores');

        return $this->request('GET', $resource, ['headers' => $headers]);
    }
}
