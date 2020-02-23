<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

use Throwable;

trait InteractsWithExceptionHandling
{
    protected $exceptionHandler;

    public function setExceptionHandler(callable $handler)
    {
        $this->exceptionHandler = $handler;

        return $this;
    }

    protected function withExceptionHandling($callback)
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    protected function handleException(Throwable $e)
    {
        return ($this->exceptionHandler ?: function ($e) {
            throw $e;
        })->__invoke($e);
    }
}
