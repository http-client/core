<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

trait ManagesMetrics
{
    public function getLatestMetrics($namespace, $metricName)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeMetricLast',
            'Namespace' => $namespace,
            'MetricName' => $metricName,
        ]);
    }

    public function getMetricList($namespace, $metricName, array $params = [])
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeMetricList',
            'MetricName' => $metricName,
            'Namespace' => $namespace,
        ] + $params);
    }

    public function getMetrics($namespace, $metricName, array $params = [])
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeMetricData',
            'Namespace' => $namespace,
            'MetricName' => $metricName,
        ] + $params);
    }
}
