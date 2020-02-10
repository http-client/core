<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ResourceAccessManagement;

trait ManagesRoles
{
    public function getRole($name)
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'GetRole', 'RoleName' => $name]);
        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function getRoles()
    {
        $query = $this->mergeDefaultAuthenticationAttributes(['Action' => 'ListRoles']);

        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function createRole($name, array $assumeRolePolicyDocument, $description = null)
    {
        $query = $this->mergeDefaultAuthenticationAttributes([
            'Action' => 'CreateRole',
            'RoleName' => $name,
            'AssumeRolePolicyDocument' => json_encode($assumeRolePolicyDocument),
            'Description' => $description,
        ]);

        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }

    public function updateRole($name, array $assumeRolePolicyDocument)
    {
        $query = $this->mergeDefaultAuthenticationAttributes([
            'Action' => 'UpdateRole',
            'RoleName' => $name,
            'NewAssumeRolePolicyDocument' => json_encode($assumeRolePolicyDocument),
        ]);

        $query['Signature'] = $this->calculateSignature($query);

        return $this->request('GET', '/', compact('query'));
    }
}
