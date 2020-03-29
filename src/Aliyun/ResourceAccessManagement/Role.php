<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

class Role extends Client
{
    /**
     * @param string $name
     *
     * @return \HttpClient\Core\Response
     */
    public function get($name)
    {
        return $this->request([
            'Action' => 'GetRole',
            'RoleName' => $name,
        ]);
    }

    /**
     * @param string      $name
     * @param string|null $description
     *
     * @return \HttpClient\Core\Response
     */
    public function create($name, array $policy, $description = null)
    {
        return $this->request([
            'Action' => 'CreateRole',
            'RoleName' => $name,
            'AssumeRolePolicyDocument' => json_encode($policy),
            'Description' => $description,
        ]);
    }

    /**
     * @param string $name
     *
     * @return \HttpClient\Core\Response
     */
    public function update($name, array $policy = null)
    {
        return $this->request([
            'Action' => 'UpdateRole',
            'RoleName' => $name,
            'NewAssumeRolePolicyDocument' => $policy ? json_encode($policy) : null,
        ]);
    }

    public function attach($roleName, $policyType, $policyName)
    {
        return $this->request([
            'Action' => 'AttachPolicyToRole',
            'RoleName' => $roleName,
            'PolicyType' => $policyType,
            'PolicyName' => $policyName,
        ]);
    }
}
