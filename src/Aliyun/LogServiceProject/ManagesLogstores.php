<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\LogServiceProject;

trait ManagesLogstores
{
    public function getLogstores()
    {
        $headers = $this->authenticateWithHeaders('GET', $resource = '/logstores');

        return $this->request('GET', $resource, ['headers' => $headers]);
    }
}
