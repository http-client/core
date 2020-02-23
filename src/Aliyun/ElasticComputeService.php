<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ElasticComputeService extends Client
{
    use ElasticComputeService\EncapsulatesRequests,
        ElasticComputeService\ManagesSecurityGroups;

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setBaseUri('https://'.$this->options['endpoint']);
    }
}
