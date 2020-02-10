<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

trait ManagesObjects
{
    public function putObject($objectName, $content)
    {
        $resource = '/'.$objectName;

        $headers = $this->authenticateWithHeaders('PUT', '/'.$this->options['bucket_name'].$resource);

        return $this->request('PUT', $resource, [
            'headers' => $headers,
            'body' => $content,
        ]);
    }
}
