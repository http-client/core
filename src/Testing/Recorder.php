<?php

namespace HttpClient\Testing;

use PHPUnit\Framework\Assert;

class Recorder
{
    /**
     * @var array
     */
    protected $recorded = [];

    public function handler()
    {
        return function ($handler) {
            return function ($request, $options) use ($handler) {
                return $handler($request, $options)->then(function ($response) use ($request, $options) {
                    array_push($this->recorded, [$request, $response]);

                    return $response;
                });
            };
        };
    }

    public function assertSent($callback)
    {
        Assert::assertTrue(
            count($this->recorded($callback)) > 0, 'An expected request was not recorded.'
        );

        return $this;
    }

    /**
     * Assert how many requests have been recorded.
     *
     * @param $count
     * @return void
     */
    public function assertSentCount($count)
    {
        Assert::assertCount($count, $this->recorded);

        return $this;
    }

    public function recorded($callback)
    {
        return array_filter($this->recorded, function ($record) use ($callback) {
            return $callback(...$record);
        });
    }
}
