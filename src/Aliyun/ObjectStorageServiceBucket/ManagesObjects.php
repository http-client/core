<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageServiceBucket;

trait ManagesObjects
{
    public function headObject($objectName)
    {
        $resource = '/'.$objectName;

        $headers = $this->authenticateWithHeaders('HEAD', '/'.$this->options['bucket_name'].$resource);

        return $this->request('HEAD', $resource, [
            'headers' => $headers,
        ]);
    }

    public function getObject($objectName)
    {
        $resource = '/'.$objectName;

        $headers = $this->authenticateWithHeaders('GET', '/'.$this->options['bucket_name'].$resource);

        return $this->withoutResponseCasting(function () use ($resource, $headers) {
            return $this->request('GET', $resource, [
                'headers' => $headers,
            ]);
        });
    }

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
