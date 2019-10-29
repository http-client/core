<?php

declare(strict_types=1);

namespace WeForge\Concerns;

trait ObservesHandler
{
    /**
     * @param callable $handler
     *
     * @return mixed
     */
    public function observe()
    {
        [$handler, $args] = func_get_args();

        return call_user_func_array($handler, $args);
    }
}
