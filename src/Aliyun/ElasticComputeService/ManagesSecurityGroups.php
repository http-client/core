<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ElasticComputeService;

trait ManagesSecurityGroups
{
    public function createSecurityGroup(array $params)
    {
        return $this->encapsulateRequest([
            'Action' => 'CreateSecurityGroup',
        ] + $params);
    }

    public function getSecurityGroups($region, array $params = [])
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeSecurityGroups',
            'RegionId' => $region,
        ] + $params);
    }
}
