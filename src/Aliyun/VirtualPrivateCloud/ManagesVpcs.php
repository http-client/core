<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\VirtualPrivateCloud;

trait ManagesVpcs
{
    public function getVpc($vpcId, $regionId)
    {
        return $this->request(['Action' => 'DescribeVpcAttribute', 'RegionId' => $regionId, 'VpcId' => $vpcId]);
    }

    public function getVpcs($regionId)
    {
        return $this->request(['Action' => 'DescribeVpcs', 'RegionId' => $regionId]);
    }

    public function createVpc(array $params)
    {
        return $this->request(array_merge(['Action' => 'CreateVpc'], $params));
    }
}
