<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

class Region extends Client
{
    public function list($filesystemType = null, $pageNumber = null, $pageSize = null)
    {
        return $this->request([
            'Action' => 'DescribeRegions',
            'FileSystemType' => $filesystemType,
            'PageNumber' => $pageNumber,
            'PageSize' => $pageSize,
        ]);
    }

    public function zones($region)
    {
        return $this->request([
            'Action' => 'DescribeZones',
            'RegionId' => $region,
        ]);
    }
}
