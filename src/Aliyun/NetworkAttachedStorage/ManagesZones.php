<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

trait ManagesZones
{
    public function getZones($region)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeZones',
            'RegionId' => $region,
        ]);
    }
}
