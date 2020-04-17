<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

class VSwitch extends Client
{
    public function list($region, array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeVSwitches',
            'RegionId' => $region,
        ] + $params);
    }

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

    public function delete($switchId, $region)
    {
        return $this->request([
            'Action' => 'DeleteVSwitch',
            'RegionId' => $region,
            'VSwitchId' => $switchId,
        ]);
    }
}
