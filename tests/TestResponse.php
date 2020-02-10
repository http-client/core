<?php

declare(strict_types=1);

namespace HttpClient\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;

class TestResponse extends Response
{
    public $method;
    public $uri;
    public $options;

    public function setExpectedArguments()
    {
        return function () {
            [$this->method, $this->uri, $this->options] = func_get_args();

            return true;
        };
    }

    // public function assertMethod($expected)
    // {
    //     Assert::assertSame($this->method, $expected);

    //     return $this;
    // }

    // public function assertUri($expected)
    // {
    //     Assert::assertSame($this->uri, $expected);

    //     return $this;
    // }

    // public function assertOptions(array $expected)
    // {
    //     Assert::assertSame($this->options, $expected);

    //     return $this;
    // }
}
