<?php

declare(strict_types=1);

namespace HttpClient\Tests\Aliyun\Signature;

use HttpClient\Aliyun\Signature\RpcSignature;
use PHPUnit\Framework\TestCase;

class RpcSignatureTest extends TestCase
{
    public function testSign()
    {
        $value = RpcSignature::sign(['Foo' => 'Bar'], 'secret');

        $this->assertSame('pd57AhhrcKS9ldipjKX/vy/O7GQ=', $value);
    }
}
