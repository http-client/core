<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

trait ManagesObjects
{
    public function headObject($objectName)
    {
        return $this->request('HEAD', '/'.$objectName);
    }

    public function getObject($objectName)
    {
        return $this->request('GET', '/'.$objectName);
    }

    public function putObject($objectName, $body)
    {
        return $this->request('PUT', '/'.$objectName, ['body' => $body]);
    }
}
