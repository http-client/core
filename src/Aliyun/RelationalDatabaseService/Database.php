<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\RelationalDatabaseService;

class Database extends Client
{
    public function list($instanceId, array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeDatabases',
            'DBInstanceId' => $instanceId,
        ] + $params);
    }
}
