<?php

namespace HttpClient\Aliyun\ObjectStorageService;

class Service extends Client
{
    public function list()
    {
        return $this->request('GET', '/');
    }
}
