<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun;

use HttpClient\Aliyun\FunctionCompute;
use HttpClient\Tests\Aliyun\FunctionCompute\TestsAliases;
use HttpClient\Tests\Aliyun\FunctionCompute\TestsCustomDomains;
use HttpClient\Tests\Aliyun\FunctionCompute\TestsFunctions;
use HttpClient\Tests\Aliyun\FunctionCompute\TestsServices;
use HttpClient\Tests\Aliyun\FunctionCompute\TestsTriggers;
use HttpClient\Tests\Aliyun\FunctionCompute\TestsVersions;
use HttpClient\Tests\ClientTestCase;

class FunctionComputeTest extends ClientTestCase
{
    use TestsAliases, TestsCustomDomains, TestsFunctions, TestsServices, TestsTriggers, TestsVersions;

    protected function getClient()
    {
        return (new FunctionCompute([
            'access_key_id' => 'test-id',
            'access_key_secret' => 'test',
        ]))->setBaseUri('https://123456.cn-shenzhen.fc.aliyuncs.com');
    }
}
