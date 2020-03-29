<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogService;

class Project extends Client
{
    public function create($projectName)
    {
        return $this->request('POST', '/', [
            'json' => ['projectName' => $projectName],
        ]);
    }

    public function list()
    {
        return $this->request('GET', '/');
    }
}
