<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\CloudMonitor;

trait ManagesProjectMetas
{
    /**
     * @return mixed
     */
    public function getProjectMetas()
    {
        return $this->encapsulatesRequest([
            'Action' => 'DescribeProjectMeta',
        ]);
    }
}
