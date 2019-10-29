<?php

declare(strict_types=1);

namespace WeForge\Tests\WeChat\Pipes;

use WeForge\Tests\TestCase;
use WeForge\WeChat\Exceptions\InterpretException;
use WeForge\WeChat\Pipes\ContentInterpretation;

class ContentInterpretationTest extends TestCase
{
    public function testValidXml()
    {
        $result = call_user_func(new ContentInterpretation, '<xml><foo>bar</foo></xml>');

        $this->assertTrue(is_array($result));
        $this->assertSame(['foo' => 'bar'], $result);
    }

    public function testInvalidXml()
    {
        $this->expectException(InterpretException::class);
        call_user_func(new ContentInterpretation, 'invalid');
    }
}
