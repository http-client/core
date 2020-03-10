<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

class AccessRule extends Client
{
    public function create($accessGroupName, $sourceCidrIp, array $params = [])
    {
        return $this->encapsulatesRequest(array_merge([
            'Action' => 'CreateAccessRule',
            'AccessGroupName' => $accessGroupName,
            'SourceCidrIp' => $sourceCidrIp,
        ], $params));
    }

    public function delete($accessGroupName, $accessRuleId, $fileSystemType = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DeleteAccessRule',
            'AccessGroupName' => $accessGroupName,
            'AccessRuleId' => $accessRuleId,
            'FileSystemType' => $fileSystemType,
        ]);
    }

    public function list($accessGroupName, array $params = [])
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeAccessRules',
            'AccessGroupName' => $accessGroupName,
        ] + $params);
    }

    public function update($accessGroupName, $accessRuleId, array $params = [])
    {
        return $this->encapsulatesRequest(array_merge([
            'Action' => 'ModifyAccessRule',
            'AccessGroupName' => $accessGroupName,
            'AccessRuleId' => $accessRuleId,
        ], $params));
    }
}
