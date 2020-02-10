<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

trait Observable
{
    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @return void
     */
    public function push(callable $callback)
    {
        array_push($this->handlers, $callback);
    }

    /**
     * @param bool $condition
     *
     * @return void
     */
    public function pushWhen($condition, callable $callback)
    {
        if ($condition) {
            $this->push($callback);
        }
    }

    /**
     * Return all of the handlers.
     */
    public function handlers(): array
    {
        return $this->handlers;
    }
}
