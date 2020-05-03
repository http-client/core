<?php

namespace HttpClient\Testing;

use Closure;
use PHPUnit\Framework\Assert;

trait FakesRequests
{
    /**
     * @var array
     */
    protected $recorded = [];

    protected $fakeCallbacks = [];

    public function fake($callback = null)
    {
        if (is_array($callback)) {
            foreach ($callback as $url => $callable) {
                $this->fakeForUrl($url, $callable);
            }

            return $this;
        }

        if (is_null($callback)) {
            $callback = function () {
                return Factory::response();
            };
        }

        $this->fakeCallbacks = array_merge($this->fakeCallbacks, [
            $callback instanceof Closure ? $callback : function () use ($callback) {
                return $callback;
            },
        ]);

        return $this;
    }

    public function fakeSequence($url = '*')
    {
        $sequence = Factory::sequence();

        $this->fake([$url => $sequence]);

        return $sequence;
    }

    protected function fakeForUrl($url, $callback)
    {
        $this->fake(function ($request, $options) use ($url, $callback) {
            if ($url === '*' || $request->getUri()->getHost() === $url) {
                return $callback instanceof Closure || $callback instanceof ResponseSequence
                        ? $callback($request, $options)
                        : $callback;
            }
        });
    }

    public function buildFakerHandler()
    {
        return function ($handler) {
            return function ($request, $options) use ($handler) {
                $responses = array_filter(array_map(function ($callback) use ($request, $options) {
                    return $callback->__invoke($request, $options);
                }, $this->fakeCallbacks));

                if (empty($responses)) {
                    return $handler($request, $options);
                }

                foreach ($responses as $response) {
                    break;
                }

                if (is_array($response)) {
                    return Factory::response($response);
                }

                return $response;
            };
        };
    }

    public function buildRecorderHandler()
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
     *
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
