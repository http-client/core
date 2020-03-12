<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\RelationalDatabaseService;

class Instance extends Client
{
    public function get($instanceId, bool $expired = null)
    {
        return $this->request([
            'Action' => 'DescribeDBInstanceAttribute',
            'DBInstanceId' => $instanceId,
            'Expired' => $expired ? 'True' : 'False',
        ]);
    }

    public function list($region)
    {
        return $this->request([
            'Action' => 'DescribeDBInstances',
            'RegionId' => $region,
        ]);
    }
}
