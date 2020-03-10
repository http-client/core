<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\FunctionCompute;

class Version extends Client
{
    public function get($serviceName)
    {
        return $this->request('GET', "/{$this->apiVersion}/services/{$serviceName}/versions");
    }

    public function publish($serviceName, string $description = null)
    {
        return $this->request(
            'POST', "/{$this->apiVersion}/services/{$serviceName}/versions", ['json' => compact('description')]
        );
    }

    public function delete($serviceName, $versionId)
    {
        return $this->request('DELETE', "/{$this->apiVersion}/services/{$serviceName}/versions/{$versionId}");
    }
}
