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

    public function create($instanceId, $name, $charset, $description = null)
    {
        return $this->request([
            'Action' => 'CreateDatabase',
            'DBInstanceId' => $instanceId,
            'DBName' => $name,
            'CharacterSetName' => $charset,
            'DBDescription' => $description,
        ]);
    }
}
