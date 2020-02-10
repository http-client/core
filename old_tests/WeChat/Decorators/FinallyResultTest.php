<?php

declare(strict_types=1);

namespace WeForge\Tests\WeChat\Decorators;

use WeForge\Tests\TestCase;
use WeForge\WeChat\Decorators\FinallyResult;

class FinallyResultTest extends TestCase
{
    public function test()
    {
        $t = new FinallyResult('weforge');
        $this->assertSame('weforge', $t->content);
    }
}
