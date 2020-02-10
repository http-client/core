<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

trait ManagesAccessRules
{
    public function createAccessRule($accessGroupName, $sourceCidrIp, array $params = [])
    {
        return $this->encapsulatesRequest(array_merge([
            'Action' => 'CreateAccessRule',
            'AccessGroupName' => $accessGroupName,
            'SourceCidrIp' => $sourceCidrIp,
        ], $params));
    }

    public function deleteAccessRule($accessGroupName, $accessRuleId, $fileSystemType = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DeleteAccessRule',
            'AccessGroupName' => $accessGroupName,
            'AccessRuleId' => $accessRuleId,
            'FileSystemType' => $fileSystemType,
        ]);
    }

    public function describeAccessRules($accessGroupName, $accessRuleId = null, $fileSystemType = null, $pageNumber = null, $pageSize = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeAccessRules',
            'AccessGroupName' => $accessGroupName,
            'AccessRuleId' => $accessRuleId,
            'FileSystemType' => $fileSystemType,
            'PageNumber' => $pageNumber,
            'PageSize' => $pageSize,
        ]);
    }

    public function modifyAccessRule($accessGroupName, $accessRuleId, array $params = [])
    {
        return $this->encapsulatesRequest(array_merge([
            'Action' => 'ModifyAccessRule',
            'AccessGroupName' => $accessGroupName,
            'AccessRuleId' => $accessRuleId,
        ], $params));
    }
}
