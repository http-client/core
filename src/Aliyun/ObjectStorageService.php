<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ObjectStorageService extends Client
{
    use ObjectStorageService\EncapsulatesRequests,
        ObjectStorageService\ManagesServices;

    /**
     * Create a new bucket instance.
     *
     * @param string $name
     *
     * @return \HttpClient\Aliyun\ObjectStorageServiceBucket
     */
    public function bucket($name)
    {
        $baseUri = preg_replace('/http(s?)\:\/\//i', "$0{$name}.", $this->getBaseUri());

        return (new ObjectStorageServiceBucket($this->getOptions()))
                        ->setBaseUri($baseUri);
    }
}
