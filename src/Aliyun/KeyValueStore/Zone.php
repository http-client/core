<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\KeyValueStore;

class Zone extends Client
{
    public function list()
    {
        return $this->request([
            'Action' => 'DescribeZones',
        ]);
    }
}
