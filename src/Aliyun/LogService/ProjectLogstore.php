<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

class ProjectLogstore extends Client
{
    public function get($name)
    {
        return $this->request('GET', "/logstores/{$name}");
    }

    public function create($name, array $params = [])
    {
        return $this->request('POST', '/logstores', [
            'logstoreName' => $name,
        ] + $params);
    }

    public function list()
    {
        $headers = $this->authenticateWithHeaders('GET', $resource = '/logstores');

        return $this->request('GET', $resource, ['headers' => $headers]);
    }
}
