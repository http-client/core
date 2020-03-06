<?php

declare(strict_types=1);

namespace HttpClient\Testing;

use PHPUnit\Framework\Assert;

trait RecordsRequests
{
    /**
     * @var array
     */
    protected static $records = [];

    /**
     * @return \Closure
     */
    protected function recorderHandler()
    {
        return function ($handler) {
            return function ($request, $options) use ($handler) {
                return $handler($request, $options)->then(function ($response) use ($request, $options) {
                    if (static::faked()) {
                        array_push(static::$records, [$request, $response]);
                    }

                    return $response;
                });
            };
        };
    }

    public static function assertSent($sequence, $callback = null)
    {
        if (is_callable($sequence)) {
            $callback = $sequence;
            $sequence = 0;
        }

        Assert::assertNotNull(
            $record = static::$records[$sequence] ?? null,
            'An expected request was not recorded.'
        );

        $callback = $callback ?: function () {
            return true;
        };

        Assert::assertTrue(
            $callback->__invoke(...$record), 'An expected request was not sent.'
        );
    }
}
