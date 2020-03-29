<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

class ProjectLogstoreIndex extends Client
{
    public function get($logstoreName)
    {
        return $this->request('GET', "/logstores/{$logstoreName}/index");
    }

    public function create($logstoreName, array $params)
    {
        return $this->request('POST', "/logstores/{$logstoreName}/index", ['json' => $params]);
    }
}
