<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

trait ManagesPolicies
{
    public function getPolicy($name, $type)
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'GetPolicy', 'PolicyName' => $name, 'PolicyType' => $type]);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function getPolicies()
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'ListPolicies']);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function createPolicy($name, array $policy, $description = null)
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'CreatePolicy', 'PolicyName' => $name, 'PolicyDocument' => json_encode($policy), 'Description' => $description]);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function createPolicyVersion($name, array $policy, $RotateStrategy = null, bool $asDefault = null)
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'CreatePolicyVersion', 'PolicyName' => $name, 'PolicyDocument' => json_encode($policy), 'RotateStrategy' => $RotateStrategy, 'SetAsDefault' => $asDefault ? 'true' : 'false']);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function getPoliciesForRole($roleName)
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'ListPoliciesForRole', 'RoleName' => $roleName]);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function attachPolicyToRole($roleName, $policyName, $policyType)
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'AttachPolicyToRole', 'RoleName' => $roleName, 'PolicyName' => $policyName, 'PolicyType' => $policyType]);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }
}
