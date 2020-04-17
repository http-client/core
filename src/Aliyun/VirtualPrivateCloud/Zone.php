<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

class Zone extends Client
{
    public function list($region)
    {
        return $this->request([
            'Action' => 'DescribeZones',
            'RegionId' => $region,
        ]);
    }
}
