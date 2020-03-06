<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

trait ManagesObjects
{
    public function headObject($objectName)
    {
        return $this->encapsulateRequest('HEAD', '/'.$objectName);
    }

    public function getObject($objectName)
    {
        return $this->encapsulateRequest('GET', '/'.$objectName);
    }

    public function putObject($objectName, $body)
    {
        return $this->encapsulateRequest('PUT', '/'.$objectName, ['body' => $body]);
    }
}
