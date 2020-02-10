<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class DomainNameService extends Client
{
    use DomainNameService\EncapsulatesRequests,
        DomainNameService\ManagesDomains,
        DomainNameService\ManagesDomainRecords;

    protected $baseUri = 'https://alidns.aliyuncs.com';
}
