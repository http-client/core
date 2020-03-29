<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\KeyManagementService;

class Secret extends Client
{
    public function list()
    {
        return $this->request([
            'Action' => 'ListSecrets',
        ]);
    }

    public function create(array $params)
    {
        return $this->request([
            'Action' => 'CreateSecret',
        ] + $params);
    }

    public function put($name, $value, $version, array $params = [])
    {
        return $this->request([
            'Action' => 'PutSecretValue',
            'SecretData' => $value,
            'SecretName' => $name,
            'VersionId' => $version,
        ] + $params);
    }

    public function value($name, $version = null, $versionStage = null)
    {
        return $this->request([
            'Action' => 'GetSecretValue',
            'SecretName' => $name,
            'VersionStage' => $versionStage,
            'VersionId' => $version,
        ]);
    }

    public function info($name)
    {
        return $this->request([
            'Action' => 'DescribeSecret',
            'SecretName' => $name,
        ]);
    }
}
