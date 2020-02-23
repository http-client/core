<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\RelationalDatabaseService;

trait ManagesDBInstances
{
    public function describeDBInstances($region)
    {
        return $this->encapsulateRequest([
            'Action' => 'DescribeDBInstances',
            'RegionId' => $region,
        ]);
    }
}
