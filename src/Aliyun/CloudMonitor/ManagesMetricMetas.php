<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

trait ManagesMetricMetas
{
    public function getMetricMetaList($namespace)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeMetricMetaList',
            'Namespace' => $namespace,
        ]);
    }
}
