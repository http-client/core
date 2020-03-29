<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

class Metric extends Client
{
    public function list($metricName, $namespace, array $params = [])
    {
        return $this->request([
            'Action' => 'DescribeMetricList',
            'MetricName' => $metricName,
            'Namespace' => $namespace,
        ] + $params);
    }
}
