<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

trait ManagesVpcs
{
    public function getVpc($vpcId, $regionId)
    {
        return $this->encapsulateRequest(['Action' => 'DescribeVpcAttribute', 'RegionId' => $regionId, 'VpcId' => $vpcId]);
    }

    public function getVpcs($regionId)
    {
        return $this->encapsulateRequest(['Action' => 'DescribeVpcs', 'RegionId' => $regionId]);
    }

    public function createVpc(array $params)
    {
        return $this->encapsulateRequest(array_merge(['Action' => 'CreateVpc'], $params));
    }
}
