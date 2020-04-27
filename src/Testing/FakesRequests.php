<?php

namespace HttpClient\Testing;

use function GuzzleHttp\Promise\promise_for;
use GuzzleHttp\Psr7\Response;

trait FakesRequests
{
    /**
     * @var array
     */
    protected static $fakers = [];

    /**
     * @param callable $callback
     *
     * @return void
     */
    public static function fake($callback = null)
    {
        if (is_null($callback)) {
            $callback = function () {
                return static::response();
            };
        }

        if (is_array($callback)) {
            $callback = new ResponseSequence($callback);
        }

        array_push(static::$fakers, is_callable($callback) ? $callback : function () use ($callback) {
            return $callback;
        });
    }

    public static function faked()
    {
        return count(static::$fakers) > 0;
    }

    /**
     * Create a psr response instance.
     *
     * @param array|string|null $body
     * @param int               $status
     * @param array             $headers
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public static function response($body = null, $status = 200, $headers = [])
    {
        if (is_array($body)) {
            $body = json_encode($body);

            $headers['Content-Type'] = 'application/json';
        }

        return promise_for(new Response($status, $headers, $body));
    }

    /**
     * Build the faker handler
     *
     * @return \Closure
     */
    protected function fakerHandler()
    {
        return function ($handler) {
            return function ($request, $options) use ($handler) {
                $result = array_filter(array_map(function ($callback) use ($request, $options) {
                    return $callback->__invoke($request, $options);
                }, static::$fakers));

                if (count($result) === 0) {
                    return $handler($request, $options);
                }
                // var_dump($result);die;

                return $result[0];
            };
        };
    }
}
