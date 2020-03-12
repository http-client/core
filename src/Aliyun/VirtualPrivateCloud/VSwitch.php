<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

class VSwitch extends Client
{
    public function get($switchId, $region)
    {
        return $this->request([
            'Action' => 'DescribeVSwitchAttributes',
            'RegionId' => $region,
            'VSwitchId' => $switchId,
        ]);
    }

    public function create(array $params = [])
    {
        return $this->request(array_merge([
            'Action' => 'CreateVSwitch',
        ], $params));
    }
}
