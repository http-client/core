<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogServiceProject;

trait ManagesLogstores
{
    public function getLogstore($name)
    {
        return $this->encapsulateRequest('GET', "/logstores/{$name}");
    }

    public function createLogstore($name, $ttl, $shardCount)
    {
        return $this->encapsulateRequest('POST', '/logstores', [
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
