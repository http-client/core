<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

trait ManagesAccessGroups
{
    public function createAccessGroup($accessGroupName, $accessGroupType, $fileSystemType = null, $description = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'CreateAccessGroup',
            'AccessGroupName' => $accessGroupName,
            'AccessGroupType' => $accessGroupType,
            'FileSystemType' => $fileSystemType,
            'Description' => $description,
        ]);
    }

    public function deleteAccessGroup($accessGroupName, $fileSystemType = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DeleteAccessGroup',
            'AccessGroupName' => $accessGroupName,
            'FileSystemType' => $fileSystemType,
        ]);
    }

    public function describeAccessGroups($accessGroupName = null, $fileSystemType = null, $pageNumber = null, $pageSize = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeAccessGroups',
            'AccessGroupName' => $accessGroupName,
            'FileSystemType' => $fileSystemType,
            'PageNumber' => $pageNumber,
            'PageSize' => $pageSize,
        ]);
    }

    public function modifyAccessGroup($accessGroupName, $fileSystemType = null, $description = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'ModifyAccessGroup',
            'AccessGroupName' => $accessGroupName,
            'FileSystemType' => $fileSystemType,
            'Description' => $description,
        ]);
    }
}
