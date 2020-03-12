<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

class MountTarget extends Client
{
    public function list($fileSystemId, array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeMountTargets',
            'FileSystemId' => $fileSystemId,
        ] + $params);
    }

    public function create($fileSystemId, $networkType, $accessGroupName, array $params = [])
    {
        return $this->request([
            'Action' => 'CreateMountTarget',
            'AccessGroupName' => $accessGroupName,
            'FileSystemId' => $fileSystemId,
            'NetworkType' => $networkType,
        ] + $params);
    }

    public function delete($fileSystemId, $mountTargetDomain)
    {
        return $this->request([
            'Action' => 'DeleteMountTarget',
            'FileSystemId' => $fileSystemId,
            'MountTargetDomain' => $mountTargetDomain,
        ]);
    }

    public function update($fileSystemId, $mountTargetDomain, array $params = [])
    {
        return $this->request([
            'Action' => 'ModifyMountTarget',
            'FileSystemId' => $fileSystemId,
            'MountTargetDomain' => $mountTargetDomain,
        ] + $params);
    }
}
