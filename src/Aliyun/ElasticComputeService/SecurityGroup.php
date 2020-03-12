<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ElasticComputeService;

class SecurityGroup extends Client
{
    public function create(array $params = [])
    {
        return $this->request([
            'Action' => 'CreateSecurityGroup',
        ] + $params);
    }

    public function authorize(array $params = [])
    {
        return $this->request([
            'Action' => 'AuthorizeSecurityGroup',
        ] + $params);
    }
}
