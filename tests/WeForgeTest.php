<?php

declare(strict_types=1);

namespace WeForge\Tests;

use WeForge\WeForge;

class WeForgeTest extends TestCase
{
    public function testRunningInLaravel()
    {
        $this->assertFalse(WeForge::$runningInLaravel);
    }

    public function testResolveCacheUsing()
    {
        $this->assertNull(WeForge::$resolveCacheUsing);
        $this->assertInstanceof(WeForge::class, WeForge::resolveCacheUsing(function () {
            $this->fail('The passing callback should not be called by default.');
        }));
        $this->assertIsCallable(WeForge::$resolveCacheUsing);
    }

    public function testResolveLoggerUsing()
    {
        $this->assertNull(WeForge::$resolveLoggerUsing);
        $this->assertInstanceof(WeForge::class, WeForge::resolveLoggerUsing(function () {
            $this->fail('The passing callback should not be called by default.');
        }));
        $this->assertIsCallable(WeForge::$resolveLoggerUsing);
    }
}
