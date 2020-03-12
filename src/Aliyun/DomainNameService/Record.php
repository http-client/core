<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\DomainNameService;

class Record extends Client
{
    /**
     * @param string $type
     * @param string $domainName
     * @param string $rr
     * @param string $value
     *
     * @return \HttpClient\Core\Response
     */
    public function add($type, $domainName, $rr, $value, array $params = [])
    {
        return $this->request([
            'Action' => 'AddDomainRecord',
            'Type' => $type,
            'DomainName' => $domainName,
            'RR' => $rr,
            'Value' => $value,
        ] + $params);
    }

    /**
     * @param string $recordId
     *
     * @return \HttpClient\Core\Response
     */
    public function delete($recordId, array $params = [])
    {
        return $this->request([
            'Action' => 'DeleteDomainRecord',
            'RecordId' => $recordId,
        ] + $params);
    }
}
