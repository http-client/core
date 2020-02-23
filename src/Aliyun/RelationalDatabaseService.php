<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class RelationalDatabaseService extends Client
{
    use RelationalDatabaseService\EncapsulatesRequests,
        RelationalDatabaseService\ManagesDBInstances;

    protected $baseUri = 'https://rds.aliyuncs.com';
}
