<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogServiceProject;

trait ManagesInfo
{
    public function getInfo()
    {
        return $this->encapsulateRequest('GET', '/', );
    }
}
