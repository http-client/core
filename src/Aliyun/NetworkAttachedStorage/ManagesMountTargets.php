<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

trait ManagesMountTargets
{
    public function describeMountTargets($fileSystemId, $domain = null, $pageNumber = null, $pageSize = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeMountTargets',
            'FileSystemId' => $fileSystemId,
            'MountTargetDomain' => $domain,
            'PageNumber' => $pageNumber,
            'PageSize' => $pageSize,
        ]);
    }

    public function createMountTarget($accessGroupName, $fileSystemId, $networkType, $vpcId = null, $vpcSwitchId = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'CreateMountTarget',
            'AccessGroupName' => $accessGroupName,
            'FileSystemId' => $fileSystemId,
            'NetworkType' => $networkType,
            'VpcId' => $vpcId,
            'VSwitchId' => $vpcSwitchId,
        ]);
    }

    public function deleteMountTarget($fileSystemId, $mountTargetDomain)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DeleteMountTarget',
            'FileSystemId' => $fileSystemId,
            'MountTargetDomain' => $mountTargetDomain,
        ]);
    }

    public function modifyMountTarget($fileSystemId, $mountTargetDomain, $accessGroupName = null, $status = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'ModifyMountTarget',
            'FileSystemId' => $fileSystemId,
            'MountTargetDomain' => $mountTargetDomain,
            'AccessGroupName' => $accessGroupName,
            'Status' => $status,
        ]);
    }
}
