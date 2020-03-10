<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

class AccessGroup extends Client
{
    public function create($accessGroupName, $accessGroupType, $fileSystemType = null, $description = null)
    {
        return $this->request([
            'Action' => 'CreateAccessGroup',
            'AccessGroupName' => $accessGroupName,
            'AccessGroupType' => $accessGroupType,
            'FileSystemType' => $fileSystemType,
            'Description' => $description,
        ]);
    }

    public function delete($accessGroupName, $fileSystemType = null)
    {
        return $this->request([
            'Action' => 'DeleteAccessGroup',
            'AccessGroupName' => $accessGroupName,
            'FileSystemType' => $fileSystemType,
        ]);
    }

    public function list(array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeAccessGroups',
        ] + $params);
    }

    public function update($accessGroupName, $fileSystemType = null, $description = null)
    {
        return $this->request([
            'Action' => 'ModifyAccessGroup',
            'AccessGroupName' => $accessGroupName,
            'FileSystemType' => $fileSystemType,
            'Description' => $description,
        ]);
    }
}
