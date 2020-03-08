<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class LogService extends Client
{
    use LogService\EncapsulatesRequests,
        LogService\ManagesProjects;
}
