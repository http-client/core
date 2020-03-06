<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

/**
 * @name 函数计算
 *
 * @playgroundOption string account_id
 * @playgroundOption string access_key_id
 * @playgroundOption string access_key_secret
 */
class FunctionCompute extends Client
{
    use FunctionCompute\EncapsulatesRequests,
        FunctionCompute\ManagesAliases,
        FunctionCompute\ManagesCustomDomains,
        FunctionCompute\ManagesFunctions,
        FunctionCompute\ManagesServices,
        FunctionCompute\ManagesTriggers,
        FunctionCompute\ManagesVersions;

    /**
     * Aliyun Function Compute API version.
     *
     * @var string
     */
    protected $apiVersion = '2016-08-15';
}
