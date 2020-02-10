<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

trait ManagesRegions
{
    public function getRegions($filesystemType = null, $pageNumber = null, $pageSize = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeRegions',
            'FileSystemType' => $filesystemType,
            'PageNumber' => $pageNumber,
            'PageSize' => $pageSize,
        ]);
    }
}
