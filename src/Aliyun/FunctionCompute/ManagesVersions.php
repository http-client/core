<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

trait ManagesVersions
{
    public function getVersions($serviceName)
    {
        return $this->request('GET', "/{$this->apiVersion}/services/{$serviceName}/versions");
    }

    public function publishVersion($serviceName, string $description = null)
    {
        return $this->request(
            'POST', "/{$this->apiVersion}/services/{$serviceName}/versions", ['json' => compact('description')]
        );
    }

    public function deleteVersion($serviceName, $versionId)
    {
        return $this->request('DELETE', "/{$this->apiVersion}/services/{$serviceName}/versions/{$versionId}");
    }
}
