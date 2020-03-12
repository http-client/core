<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

class BucketObject extends Client
{
    public function head($objectName)
    {
        return $this->request('HEAD', '/'.$objectName);
    }

    public function get($name)
    {
        return $this->request('GET', '/'.$name);
    }

    public function put($objectName, $body)
    {
        return $this->request('PUT', '/'.$objectName, ['body' => $body]);
    }
}
