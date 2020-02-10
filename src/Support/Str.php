<?php

declare(strict_types=1);

namespace HttpClient\Support;

class Str
{
    public static function random($length = 16)
    {
        $value = '';
        $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

        for ($i = 0; $i < $length; ++$i) {
            $value .= $pool[mt_rand(0, strlen($pool) - 1)];
        }

        return $value;
    }
}
