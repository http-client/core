<?php

namespace WeForge\Concerns;

use Psr\Http\Message\ResponseInterface;

trait ResponseCastable
{
    /**
     * @var bool
     */
    protected $withResponseCasting = true;

    /**
     * @var callable|null
     */
    protected static $castsResponseUsing;

    /**
     * @param callable $callback
     *
     * @return static
     */
    public static function castsResponseUsing($callback)
    {
        static::$castsResponseUsing = $callback;

        return new static;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    public function castsResponse(ResponseInterface $response)
    {
        if (static::$castsResponseUsing && $this->withResponseCasting) {
            return call_user_func_array(static::$castsResponseUsing, [$response]);
        }

        return $response;
    }

    /**
     * @param callable $callback
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function withoutResponseCasting($callback)
    {
        $backup = $this->withResponseCasting;
        $this->withResponseCasting = false;

        $response = $callback();

        $this->withResponseCasting = $backup;

        return $response;
    }
}
