<?php

declare(strict_types=1);

namespace HttpClient\Concerns;

trait ObservesHandler
{
    /**
     * @param callable $handler
     * @param array    $payload
     *
     * @return mixed
     */
    public function observe()
    {
        [$handler, $payload] = func_get_args();

        return call_user_func_array($handler, [$payload]);
    }
}
