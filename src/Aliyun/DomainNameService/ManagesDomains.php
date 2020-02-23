<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\DomainNameService;

trait ManagesDomains
{
    public function getDomains(array $params = [])
    {
        return $this->encapsulateRequest(array_merge([
            'Action' => 'DescribeDomains',
        ], $params));
    }

    public function getDomain($domain)
    {
        return $this->encapsulateRequest(array_merge([
            'Action' => 'DescribeDomainInfo',
            'DomainName' => $domain,
        ]));
    }
}
