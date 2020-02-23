<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

trait ManagesProjects
{
    public function createProject($projectName)
    {
        return $this->encapsulateRequest('POST', '/', [
            'projectName' => $projectName,
        ]);
    }

    public function getProjects()
    {
        return $this->encapsulateRequest('GET', '/');
    }
}
