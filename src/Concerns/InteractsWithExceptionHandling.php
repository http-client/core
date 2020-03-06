<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

use Throwable;

trait InteractsWithExceptionHandling
{
    protected $exceptionHandler;

    public function withExceptionHandler(callable $handler)
    {
        $this->exceptionHandler = $handler;

        return $this;
    }

    public function withoutExceptionHandler()
    {
        $this->exceptionHandler = null;

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return mixed
     */
    protected function withExceptionHandling($callback)
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            return ($this->exceptionHandler ?: function ($e) {
                throw $e;
            })->__invoke($e);
        }
    }
}
