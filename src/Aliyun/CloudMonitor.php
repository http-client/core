<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class CloudMonitor extends Client
{
    use CloudMonitor\EncapsulatesRequests,
        CloudMonitor\ManagesProjectMetas,
        CloudMonitor\ManagesMetricMetas,
        CloudMonitor\ManagesMetrics;

    /**
     * HttpClient constructor.
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setBaseUri($this->options['endpoint']);
    }
}
