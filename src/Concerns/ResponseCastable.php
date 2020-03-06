<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

use Psr\Http\Message\ResponseInterface;

trait ResponseCastable
{
    /**
     * @var bool
     */
    protected $withResponseCasting = true;

    /**
     * @var mixed
     */
    protected $castResponseUsing;

    /**
     * @param mixed $value
     *
     * @ignore
     *
     * @return static
     */
    public function castResponseUsing($value)
    {
        $this->castResponseUsing = $value;

        return $this;
    }

    /**
     * @ignore
     *
     * @return mixed
     */
    public function castResponse(ResponseInterface $response)
    {
        if (($caster = $this->castResponseUsing) && $this->withResponseCasting) {
            if (is_callable($caster)) {
                return call_user_func($caster, $response);
            }

            if (is_string($caster)) {
                return new $caster($response);
            }

            if (is_array($caster)) {
                return call_user_func($caster, $response);
            }

            exit('invalid handler');
        }

        return $response;
    }

    /**
     * @ignore
     *
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
