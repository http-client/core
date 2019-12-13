<?php

declare(strict_types=1);

namespace WeClient\Concerns;

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
     */
    public function withoutResponseCasting($callback): ResponseInterface
    {
        $previous = $this->withResponseCasting;
        $this->withResponseCasting = false;

        $response = $callback($this);

        $this->withResponseCasting = $previous;

        return $response;
    }
}
