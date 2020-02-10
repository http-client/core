<?php

declare(strict_types=1);

namespace HttpClient\Tests\Signature;

use HttpClient\Aliyun\Signature\RpcSignature;

class RpcSignatureTest extends \PHPUnit\Framework\TestCase
{
    public function testSign()
    {
        $s = new RpcSignature('GET');
        $this->assertSame('xj5wLTYPZhoHdUolNh9CV3EDFyw=', $s->sign([], 'foobar'));
    }
}
