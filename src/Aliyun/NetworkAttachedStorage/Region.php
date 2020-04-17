<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

class Region extends Client
{
    public function list()
    {
        return $this->request([
            'Action' => 'DescribeRegions',
        ]);
    }
}
