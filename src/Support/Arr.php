<?php

declare(strict_types=1);

namespace HttpClient\Support;

class Arr
{
    public static function startsWith(array $items, $start)
    {
        return array_filter($items, function ($key) use ($start) {
            return strpos($key, $start) === 0;
        }, ARRAY_FILTER_USE_KEY);
    }
}
