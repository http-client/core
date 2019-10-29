<?php

declare(strict_types=1);

namespace WeForge\Concerns;

trait Observable
{
    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function push($callback)
    {
        array_push($this->handlers, $callback);
    }

    /**
     * @param bool     $condition
     * @param callable $callback
     *
     * @return void
     */
    public function pushWhen($condition, $callback)
    {
        if ($condition) {
            $this->push($callback);
        }
    }

    /**
     * Return all of the handlers.
     *
     * @return array
     */
    public function handlers()
    {
        return $this->handlers;
    }
}
