<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

class Service extends Client
{
    public function list()
    {
        return $this->request('GET', '/');
    }
}
