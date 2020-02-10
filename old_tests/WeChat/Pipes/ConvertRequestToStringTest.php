<?php

declare(strict_types=1);

namespace WeForge\Tests\WeChat\Pipes;

use Symfony\Component\HttpFoundation\Request;
use WeForge\Tests\TestCase;
use WeForge\WeChat\Pipes\ConvertRequestToString;

class ConvertRequestToStringTest extends TestCase
{
    public function test()
    {
        $request = new Request([], [], [], [], [], [], 'hello');
        $result = call_user_func(new ConvertRequestToString, $request);

        $this->assertTrue(is_string($result));
        $this->assertSame('hello', $result);
    }

    public function testEmpty()
    {
        $result = call_user_func(new ConvertRequestToString, new Request);

        $this->assertTrue(is_string($result));
        $this->assertSame('', $result);
    }
}
