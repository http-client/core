<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

use GuzzleHttp\Exception\GuzzleException;

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
        } catch (GuzzleException $e) {
            if ($this->exceptionHandler) {
                return $this->exceptionHandler->__invoke($e);
            }

            throw $e;
        }
    }
}
