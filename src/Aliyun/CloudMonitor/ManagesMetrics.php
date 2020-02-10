<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

trait ManagesMetrics
{
    public function getMetricList($metricName, $namespace)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeMetricList',
            'MetricName' => $metricName,
            'Namespace' => $namespace,
        ]);
    }
}
