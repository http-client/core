<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

trait ManagesSwitches
{
    public function getSwitch($switchId, $region)
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeVSwitchAttributes',
            'RegionId' => $region,
            'VSwitchId' => $switchId,
        ]);
    }

    public function createSwitch(array $params = [])
    {
        return $this->encapsulateRequest(array_merge([
            'Action' => 'CreateVSwitch',
        ], $params));
    }
}
