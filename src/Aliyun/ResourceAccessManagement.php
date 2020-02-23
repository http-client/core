<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class ResourceAccessManagement extends Client
{
    use ResourceAccessManagement\EncapsulatesRequests;
    use ResourceAccessManagement\NeedsAuthentication,
        ResourceAccessManagement\ManagesUsers,
        ResourceAccessManagement\ManagesRoles,
        ResourceAccessManagement\ManagesPolicies;

    protected $baseUri = 'https://ram.aliyuncs.com';
}
