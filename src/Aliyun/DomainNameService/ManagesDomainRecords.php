<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\DomainNameService;

trait ManagesDomainRecords
{
    public function getDomainRecords($domainName, array $params = [])
    {
        return $this->encapsulateRequest(array_merge([
            'Action' => 'DescribeDomainRecords',
            'DomainName' => $domainName,
        ], $params));
    }

    public function addDomainRecord($domain, $resourceRecord, $type, $value, array $params = [])
    {
        return $this->encapsulateRequest(array_merge([
            'Action' => 'AddDomainRecord',
            'DomainName' => $domain,
            'RR' => $resourceRecord,
            'Type' => $type,
            'Value' => $value,
        ], $params));
    }
}
