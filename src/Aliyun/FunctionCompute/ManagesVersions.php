<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

trait ManagesVersions
{
    public function getVersions($serviceName, array $query = [])
    {
        return $this->requestResource('GET', "/{$this->apiVersion}/services/{$serviceName}/versions", compact('query'));
    }

    public function publishVersion($serviceName, string $description)
    {
        return $this->requestResource(
            'POST', "/{$this->apiVersion}/services/{$serviceName}/versions", ['json' => compact('description')]
        );
    }

    public function deleteVersion($serviceName, $versionId)
    {
        return $this->requestResource('DELETE', "/{$this->apiVersion}/services/{$serviceName}/versions/{$versionId}");
    }
}
