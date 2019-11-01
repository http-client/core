<?php

declare(strict_types=1);

namespace WeForge\Tests\WeChat\Pipes;

use WeForge\Tests\TestCase;
use WeForge\WeChat\Encryption\DecryptException;
use WeForge\WeChat\Pipes\DecryptDataIfNecessary;

class DecryptDataIfNecessaryTest extends TestCase
{
    public function testUnnecessary()
    {
        $result = call_user_func(new DecryptDataIfNecessary('wxb11529c136998cb6', 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG'), ['Foo' => 'foobar']);

        $this->assertSame(['Foo' => 'foobar'], $result);
    }

    public function testNecessary()
    {
        $this->expectException(DecryptException::class);
        call_user_func(new DecryptDataIfNecessary('wxb11529c136998cb6', 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG'), ['Encrypt' => 'foobar']);
    }
}
